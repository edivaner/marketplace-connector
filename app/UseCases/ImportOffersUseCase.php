<?php
namespace App\UseCases;

// use App\Domain\State\ImportContext;
use App\UseCases\Contracts\ImportOffersUseCaseInterface;
use App\Jobs\ImportOffersPageJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportOffersUseCase implements ImportOffersUseCaseInterface
{
    /**
     * Execute the import offers use case.
     *
     * @return string The import ID.
     */
    public function execute(): string {
        $importId = Str::uuid()->toString();
        ImportOffersPageJob::dispatch($importId, 1)->onQueue('offers');

        Log::info("Iniciando importação dos anúncios com ID: $importId");
        return $importId;
    }
}

?>