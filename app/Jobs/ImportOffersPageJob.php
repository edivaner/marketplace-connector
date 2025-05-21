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
use App\Jobs\ImportOfferDetailJob;

class ImportOffersPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */

    public string $importId;
    public int $page;
    public int $tries = 3;

    public function __construct(string $importId, int $page){
        $this->importId = $importId;
        $this->page = $page;
    }
    
    public function middleware(){
        return [new ThrottlesExceptions(2, 10)];
    }

    public function backoff(){
        return [10, 30, 60];
    }

    /**
     * Execute the job.
     */
    public function handle(OfferImportServiceInterface $service, OfferRepositoryInterface $repository): void {
        Log::info("[{$this->importId}] Iniciando importação da página {$this->page}");

        $response = $service->getPage($this->page);

        foreach($response->offers() as $offerId){

            if ($repository->exists($offerId)) {
                Log::info("[{$this->importId}] oferta {$offerId} já importada.");
                continue;
            }

            ImportOfferDetailJob::dispatch($this->importId, $offerId)->onQueue('offer_details');
            Log::info("[{$this->importId}] Foi inicializado a importaçao dos detalhes da oferta: {$offerId}");
        }
    }

    public function failed(\Throwable $exception){
        Log::error("[{$this->importId}] Falha na importação da página {$this->page}: {$exception->getMessage()}");
    }
}
