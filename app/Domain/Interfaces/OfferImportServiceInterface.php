<?php
namespace App\Domain\Interfaces;

use App\Domain\Entities\OfferDetail;
use App\Domain\Entities\PageResponse;
use App\DTOs\HubOfferDto;

interface OfferImportServiceInterface
{
    /**
     * Get the page of offers.
     * 
     * @param int $page
     * @return PageResponse
     */
    public function getPage(int $page): PageResponse;
    /**
     * Get the page of offers.
     * 
     * @param int $page
     * @return OfferDetail
     */
    public function getOfferDetail(string $id): OfferDetail;

    /**
     * Get the offer images.
     * 
     * @param string $id
     * @return array
     */
    public function getOfferImages(string $id): array;

    /**
     * Get the offer price.
     * 
     * @param string $id
     * @return float
     */
    public function getOfferPrice(string $id): float;

    /**
     * Send the payload to the hub.
     * 
     * @param array $payload
     * @return void
     */
    public function sendToHub(HubOfferDto $payload): void;
}
?>