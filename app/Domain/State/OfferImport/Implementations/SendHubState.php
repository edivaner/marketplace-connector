<?php
namespace App\Domain\State\OfferImport\Implementations;

use App\Domain\State\OfferImport\Contracts\OfferImportStateInterface;
use App\Domain\State\OfferImport\OfferImportContext;
use App\DTOs\HubOfferDto;
use Illuminate\Support\Facades\Log;

class SendHubState implements OfferImportStateInterface {
    /**
     * @inheritDoc
     */
    public function handle(OfferImportContext $context): void {
        Log::info("[{$context->importId}] [Oferta {$context->offerId}] enviando para o Hub");
        
        $dto = new HubOfferDto(
            $context->detail->title(),
            $context->detail->description(),
            $context->detail->status(),
            $context->detail->stock(),
        );

        $context->service->sendToHub($dto);
        
        // está será a etapa final
        $context->setState(new CompletedOfferState());
        $context->proceed();
    }
}
