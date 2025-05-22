<?php
namespace App\Domain\State\OfferImport\Implementations;

use App\Domain\State\OfferImport\Contracts\OfferImportStateInterface;
use App\Domain\State\OfferImport\OfferImportContext;
use Illuminate\Support\Facades\Log;

class FetchDetailState implements OfferImportStateInterface {
    /**
     * @inheritDoc
     */
    public function handle(OfferImportContext $context): void {
        Log::info("[{$context->importId}] [Oferta {$context->offerId}] buscando detalhes");

        $context->detail = $context->service->getOfferDetail($context->offerId);
        $context->setState(new FetchImagesState());
        $context->proceed();
    }
}
