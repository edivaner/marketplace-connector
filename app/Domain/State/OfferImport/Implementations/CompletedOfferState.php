<?php
namespace App\Domain\State\OfferImport\Implementations;

use App\Domain\State\OfferImport\Contracts\OfferImportStateInterface;
use App\Domain\State\OfferImport\OfferImportContext;
use Illuminate\Support\Facades\Log;

class CompletedOfferState implements OfferImportStateInterface {
    /**
     * @inheritDoc
     */
    public function handle(OfferImportContext $context): void
    {
        Log::info("[{$context->importId}] [Oferta {$context->offerId}] Importação completa com sucesso.");
        // não há próximo . acabou.
    }
}
