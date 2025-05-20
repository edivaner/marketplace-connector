<?php

namespace App\Jobs;

use App\Domain\Interfaces\OfferImportServiceInterface;
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
    public function handle(OfferImportServiceInterface $service): void {

    }
    
    public function failed(\Throwable $exception): void {
        Log::error("[{$this->importId}] Falha na oferta {$this->offerId}: {$exception->getMessage()}");
    }
}
