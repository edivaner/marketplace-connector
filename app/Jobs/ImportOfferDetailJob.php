<?php

namespace App\Jobs;

use App\Domain\Interfaces\OfferImportServiceInterface;
use App\Domain\Interfaces\OfferRepositoryInterface;
use App\Domain\State\OfferImport\OfferImportContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportOfferDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public string $importId;
    public string $offerId;

    public $tries = 3;
    /**
     * Create a new job instance.
     */
    public function __construct(string $importId, string $offerId){
        $this->importId = $importId;
        $this->offerId = $offerId;
    }

    public function middleware(){
        return [new ThrottlesExceptions(3, 10)];
    }
    /**
     * Execute the job.
     * @param OfferImportServiceInterface $service
     * @param OfferRepositoryInterface $repository
     * @return void
     */
    public function handle(OfferImportServiceInterface $service, OfferRepositoryInterface    $repository): void {
        Log::info("[{$this->importId}] [Oferta {$this->offerId}] Iniciando importação dos detalhes da oferta");
        
        // Inicializa fluxo de state (Controla as importações de detalhes, imagens, preço e os states para salvar no banco e no Hub)
        $context = new OfferImportContext($this->importId, $this->offerId, $service, $repository);
        $context->proceed();
    }

    /**
     * Define the backoff time for the job.
     * @param Throwable $exception
     * @return array
     */
    public function failed(\Throwable $exception): void {
        Log::error("[{$this->importId}] Falha na oferta {$this->offerId}: {$exception->getMessage()}");
    }
}
