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
use App\Domain\Entities\PageResponse;

class ImportOffersPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */

    public string $importId;
    public int $page;
    public int $tries = 3;

    /**
     * Create a new job instance.
     *
     * @param string $importId
     * @param int $page
     */
    public function __construct(string $importId, int $page){
        $this->importId = $importId;
        $this->page = $page;
    }
    
    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware(){
        return [new ThrottlesExceptions(2, 10)];
    }
    
    /**
     * Define the backoff time for the job.
     *
     * @return array
     */
    public function backoff(): array{
        return [10, 30, 60];
    }

    /**
     * Execute the job.
     * @param OfferImportServiceInterface $service
     * @param OfferRepositoryInterface $repository
     * @return void
     */
    public function handle(OfferImportServiceInterface $service, OfferRepositoryInterface $repository): void {
        Log::info("[{$this->importId}] Iniciando importação da página {$this->page}");
    
        /** @var PageResponse $response */
        $response = $service->getPage($this->page);

        foreach($response->offers() as $offerId){
            if ($repository->exists($offerId)) {
                Log::info("[{$this->importId}] [Oferta {$offerId}] já importada.");
                continue;
            }

            ImportOfferDetailJob::dispatch($this->importId, $offerId)->onQueue('offer_details');
            Log::info("[{$this->importId}] [Oferta {$offerId}] Foi inicializado a importaçao dos detalhes da oferta");
        }

        Log::info("[{$this->importId}] Importação da página {$this->page} concluída");

        if ($response->nextPage() !== null) {
            $next = $response->nextPage();
            Log::info("[{$this->importId}] Agendando paginação para próxima página: {$next}");
            self::dispatch($this->importId, $next)->onQueue('offers');
        } 
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception): void{
        Log::error("[{$this->importId}] Falha na importação da página {$this->page}: {$exception->getMessage()}");
    }
}
