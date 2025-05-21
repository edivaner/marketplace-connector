<?php
namespace App\Services;

use App\Domain\Entities\OfferDetail;
use App\Domain\Entities\PageResponse;
use App\Domain\Interfaces\OfferImportServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OfferImportService implements OfferImportServiceInterface
{
    private string $baseUrl;

    public function __construct(){
        $this->baseUrl = 'http://mock-api:3000';
    }

    public function getPage(int $page){
        try {
            $response = Http::baseUrl($this->baseUrl)->get("/offers?page={$page}");

            if ($response->status() === 404) {
                Log::warning("Página {$page} não encontrada na API de ofertas.");
                return new PageResponse([], $page, 1, null);
            }

            $data = $response->throw()->json();
            return PageResponse::fromArray($data);
        } catch (\Throwable $e) {
            Log::error("Erro ao buscar página {$page}: " . $e->getMessage());
            return new PageResponse([], $page, 1, null);
        }
    }

    public function getOfferDetail(string $id): OfferDetail{
        Log::info("Buscando detalhes da oferta {$id}");

        try {
            $response = Http::baseUrl($this->baseUrl)->get("/offers/{$id}");

            if ($response->status() === 404) {
                Log::warning("Detalhes da oferta {$id} não encontrados.");
                throw new \RuntimeException("Detalhes da oferta {$id} não encontrados.");
            }

            $data = $response->throw()->json('data');
            return OfferDetail::fromArray($data);
        } catch (\Throwable $e) {
            Log::error("Erro ao buscar detalhes da oferta {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function getOfferImages(string $id){
        Log::info("Buscando imagens da oferta {$id}");

        try {
            $response = Http::baseUrl($this->baseUrl)->get("/offers/{$id}/images");

            if ($response->status() === 404) {
                Log::warning("Imagens da oferta {$id} não encontradas.");
                return []; 
            }

            $raw = $response->throw()->json('data.images') ?: [];
            return array_map(fn($item) => $item['url'] ?? '', $raw);
            
            // $images = $response->throw()->json('data.images');
            //return is_array($images) ? $images : [];
        } catch (\Throwable $e) {
            Log::error("Erro ao buscar imagens da oferta {$id}: " . $e->getMessage());
            return []; 
        }
    }

    public function getOfferPrice(string $id){
        Log::info("Buscando preço da oferta {$id}");

        try {
            $response = Http::baseUrl($this->baseUrl)->get("/offers/{$id}/prices");

            if ($response->status() === 404) {
                Log::warning("Endpoint de preço não encontrado para oferta {$id}. Definindo preço como 0.0");
                return 0.0;
            }

            $price = $response->throw()->json('data.price');
            return $price;
        } catch (\Throwable $e) {
            Log::error("Erro ao buscar preço da oferta {$id}: " . $e->getMessage());
            return 0.0; 
        }
    }

    public function sendToHub(array $payload){
        Log::info("Enviando payload para o HUB");

        try {
            $response = Http::baseUrl($this->baseUrl)->post('/hub/create-offer', $payload);

            if ($response->status() === 404) {
                Log::warning("Endpoint do HUB não encontrado.");
                return;
            }

            $response->throw();
            Log::info("Payload enviado ao HUB com sucesso.");
        } catch (\Throwable $e) {
            Log::error("Erro ao enviar payload para o HUB: " . $e->getMessage());
        }
    }
}
?>