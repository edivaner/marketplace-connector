<?php
namespace App\Services;

use App\Domain\Interfaces\OfferImportServiceInterface;

class OfferImportService implements OfferImportServiceInterface
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://mock-api:3000';
    }

    public function getPage(int $page){}

    public function getOfferDetail(string $id){}

    public function getOfferImages(string $id){}

    public function getOfferPrice(string $id){}

    public function sendToHub(array $payload){}
}
?>