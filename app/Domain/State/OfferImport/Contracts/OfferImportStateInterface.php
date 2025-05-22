<?php
namespace App\Domain\State\OfferImport\Contracts;

use App\Domain\State\OfferImport\OfferImportContext;

interface OfferImportStateInterface {
    /**
     * Handle the state transition.
     *
     * @param OfferImportContext $context
     * @return void
     */
    public function handle(OfferImportContext $context): void;
}
