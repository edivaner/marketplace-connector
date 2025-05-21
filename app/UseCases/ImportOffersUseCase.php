<?php
namespace App\UseCases;

use App\Domain\State\ImportContext;
use App\UseCases\Contracts\ImportOffersUseCaseInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportOffersUseCase implements ImportOffersUseCaseInterface
{
    public function execute(): string
    {
        $importId = Str::uuid()->toString();

        // Agendar a execução de um job para importar os anúncios
        $context = new ImportContext($importId);
        Log::info("Iniciando importação dos anúncios com ID: $importId");
        $context->proceed(1);
        
        return $importId;
    }
}

?>