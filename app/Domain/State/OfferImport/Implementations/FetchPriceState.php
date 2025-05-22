<?php
namespace App\Domain\State\OfferImport\Implementations;

use App\Domain\State\OfferImport\Contracts\OfferImportStateInterface;
use App\Domain\State\OfferImport\OfferImportContext;
use Illuminate\Support\Facades\Log;

class FetchPriceState implements OfferImportStateInterface {
    /**
     * @inheritDoc
     */
    public function handle(OfferImportContext $context): void {
        Log::info("[{$context->importId}] [Oferta {$context->offerId}] buscando preço");
        
        $context->price = $context->service->getOfferPrice($context->offerId);
        
        $context->setState(new \App\Domain\State\OfferImport\Implementations\SaveState());
        $context->proceed();
    }
}
