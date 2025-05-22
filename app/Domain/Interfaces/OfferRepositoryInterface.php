<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\OfferDetail;

interface OfferRepositoryInterface {
    
    /**
     * Salva no banco de dados uma oferta.
     *
     * @param OfferDetail $detail
     * @param float $price
     * @param array $images
     * @return void
     */
    public function save(OfferDetail $detail, float $price, array $images): void;

    /**
     * Verifica se uma oferta já existe no banco de dados.
     *
     * @param string $offerId ID da oferta a ser verificada.
     * @return bool Retorna true se a oferta existir, caso contrário, false.
     */
    public function exists(string $offerId): bool; 
}
