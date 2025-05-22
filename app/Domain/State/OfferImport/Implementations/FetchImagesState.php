<?php
namespace App\Domain\State\OfferImport\Implementations;

use App\Domain\State\OfferImport\Contracts\OfferImportStateInterface;
use App\Domain\State\OfferImport\OfferImportContext;
use Illuminate\Support\Facades\Log;

class FetchImagesState implements OfferImportStateInterface {
    /**
     * @inheritDoc
     */
    public function handle(OfferImportContext $context): void{
        Log::info("[{$context->importId}] [Oferta {$context->offerId}] buscando imagens");
        
        $context->images = $context->service->getOfferImages($context->offerId);
        $context->setState(new FetchPriceState());
        $context->proceed();
    }
}
