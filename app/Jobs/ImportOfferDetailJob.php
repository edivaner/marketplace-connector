<?php

namespace App\Jobs;

use App\Domain\Interfaces\OfferImportServiceInterface;
use App\Domain\Interfaces\OfferRepositoryInterface;
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
     */
    public function handle(OfferImportServiceInterface $service, OfferRepositoryInterface $repository): void {
        Log::info("[{$this->importId}] Iniciando importação dos detalhes da oferta {$this->offerId}");

        if ($repository->exists($this->offerId)) {
            Log::info("[{$this->importId}] Oferta {$this->offerId} já importada. Ignorando importação dos detalhes.");
            return;
        }

        // pegar os detalhes da offer
        $detail = $service->getOfferDetail($this->offerId);
        $price = $service->getOfferPrice($this->offerId);
        $images = $service->getOfferImages($this->offerId);
       
        // salvar no banco
        $repository->save($detail, $price, $images);
        Log::info("[{$this->importId}] oferta {$this->offerId}, foi importada com sucesso no banco de dados");

        // salvar no HUB (mock POST)
        $service->sendToHub([
            'title'       => $detail->title(),
            'description' => $detail->description(),
            'status'      => $detail->status(),
            'stock'       => $detail->stock(),
        ]);
        Log::info("[{$this->importId}] Oferta {$this->offerId} importada com sucesso");
    }
    
    public function failed(\Throwable $exception): void {
        Log::error("[{$this->importId}] Falha na oferta {$this->offerId}: {$exception->getMessage()}");
    }
}
