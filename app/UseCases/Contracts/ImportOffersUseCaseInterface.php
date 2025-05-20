<?php

namespace App\UseCases\Contracts;

interface ImportOffersUseCaseInterface
{
    /**
     * Inicia o processo de importação
     */
    public function execute(): string;
}
