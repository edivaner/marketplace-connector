<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\OfferDetail;

interface OfferRepositoryInterface {
    
    public function save(OfferDetail $detail, float $price, array $images): void;

    public function exists(string $offerId): bool;  // ← nova assinatura
}
