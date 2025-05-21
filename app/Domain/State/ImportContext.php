<?php

namespace App\Domain\State;

use App\Domain\State\Contracts\ImportStateInterface;
use App\Domain\State\Implementations\NewState;
use App\Jobs\ImportOffersPageJob;
use Illuminate\Support\Facades\Log;

class ImportContext{

    private ImportStateInterface $state;
    private int $currentPAge = 0;
    private ?int $totalPages = null;
    private bool $isFailed = false;
    private string $importId;

    public function __construct(string $importId){
        $this->importId = $importId;
        $this->state = new NewState();
    }

    public function setState(ImportStateInterface $state){
        $this->state = $state;
        Log::info("[{$this->importId}] State mudando para o status " . (new \ReflectionClass($state))->getShortName());
    }
    public function getState(): ImportStateInterface {
        return $this->state;
    }

    public function proceed(int $page){
        $this->currentPAge = $page;
        $this->state->handlePage($this, $page);
    }

    public function dispatchPageJob(int $page){
        Log::info("[{$this->importId}] State iniciando importação para o JOB ImportOffersPageJob page: {$page}");
        ImportOffersPageJob::dispatch($this->importId, $page)->onQueue('offers');
    }

    public function hasMorePages(){
        return $this->totalPages === null || $this->currentPAge < $this->totalPages;
    }

    public function setTotalPages(int $total){
        $this->totalPages = $total;
    }

    public function markFailed(){
        $this->isFailed = true;
        $this->setState(new Implementations\FailedState());
    }

    public function markCompleted(): void{
        Log::info("[{$this->importId}] Importação concluída com sucesso.");
    }

    public function isFailed(): bool{
        return $this->isFailed;
    }

    public function getImportId(){
        return $this->importId;
    }
}