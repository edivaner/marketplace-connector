<?php
namespace App\Domain\State\OfferImport\Implementations;

use App\Domain\State\OfferImport\Contracts\OfferImportStateInterface;
use App\Domain\State\OfferImport\OfferImportContext;
use Illuminate\Support\Facades\Log;

class SaveState implements OfferImportStateInterface {
    /**
     * @inheritDoc
     */
    public function handle(OfferImportContext $context): void
    {
        $context->repository->save(
            $context->detail,
            $context->price,
            $context->images
        );
        Log::info("[{$context->importId}] [Oferta {$context->offerId}] Foi adicionada no banco de dados");

        // próxima fase: enviar ao hub
        $context->setState(new SendHubState());
        $context->proceed();
    }
}
