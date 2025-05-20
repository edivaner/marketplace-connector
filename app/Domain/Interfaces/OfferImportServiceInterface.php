<?php
namespace App\Domain\Interfaces;

interface OfferImportServiceInterface
{
    public function getPage(int $page);

    public function getOfferDetail(string $id);

    public function getOfferImages(string $id);

    public function getOfferPrice(string $id);

    public function sendToHub(array $payload);
}
?>