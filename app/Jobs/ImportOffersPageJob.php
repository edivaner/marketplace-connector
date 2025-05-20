<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Jobs\ImportOfferDetailJob;
use App\Services\OfferImportService;

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
    public function handle(OfferImportService $service): void
    {

    }

    public function failed(\Throwable $exception){
        Log::error("[{$this->importId}] Falha na importação da página {$this->page}: {$exception->getMessage()}");
    }
}
