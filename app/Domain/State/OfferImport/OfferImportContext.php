<?php
namespace App\Domain\State\OfferImport;

use App\Domain\Entities\OfferDetail;
use App\Domain\State\OfferImport\Contracts\OfferImportStateInterface;
use App\Domain\Interfaces\OfferImportServiceInterface;
use App\Domain\Interfaces\OfferRepositoryInterface;
use App\Domain\State\OfferImport\Implementations\FetchDetailState;

class OfferImportContext {
    public string $importId;
    public string $offerId;
    public OfferImportStateInterface $state;
    public OfferImportServiceInterface $service;
    public OfferRepositoryInterface $repository;

    public OfferDetail $detail;
    public array $images = [];
    public float $price = 0.0;

    /**
     * @param string $importId
     * @param string $offerId
     * @param OfferImportServiceInterface $service
     * @param OfferRepositoryInterface $repository
     */
    public function __construct(string $importId, string $offerId, OfferImportServiceInterface $service, OfferRepositoryInterface $repository) {
        $this->importId   = $importId;
        $this->offerId    = $offerId;
        $this->service    = $service;
        $this->repository = $repository;

        // início do fluxo de estados na etapa de detalhes
        $this->state      = new FetchDetailState();
    }

    /**
     * @param OfferImportStateInterface
     * @return void
     */
    public function setState(OfferImportStateInterface $state): void {
        $this->state = $state;
    }

    /**
     * @return void
     */
    public function proceed(): void {
        $this->state->handle($this);
    }
}
