<?php
namespace App\UseCases;

use App\Jobs\ImportOffersPageJob;
use App\UseCases\Contracts\ImportOffersUseCaseInterface;
use Illuminate\Support\Str;

class ImportOffersUseCase implements ImportOffersUseCaseInterface
{
    public function execute(): string
    {
        $importId = Str::uuid()->toString();

        // Dispara o job para importar as ofertas
        ImportOffersPageJob::dispatch($importId, 1)->onQueue('offers')->delay(now());

        return $importId;
    }
}

?>