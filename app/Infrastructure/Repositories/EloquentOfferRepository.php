<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\OfferDetail;
use App\Domain\Interfaces\OfferRepositoryInterface;
use App\Models\OfferImageModel;
use App\Models\OfferModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EloquentOfferRepository implements OfferRepositoryInterface {

    public function save(OfferDetail $detail, float $price, array $images): void {
        Log::info("Persistindo oferta {$detail->id()} no banco de dados.");

        if ($this->exists($detail->id())) {
            Log::info("Repositório: oferta {$detail->id()} já existe. Pulando persistência.");
            return;
        }     

        DB::transaction(function () use ($detail, $price, $images) {
            $offer = OfferModel::updateOrCreate(
                ['marketplace_order_id' => $detail->id()],
                [
                    'title'       => $detail->title(),
                    'description' => $detail->description(),
                    'status'      => $detail->status(),
                    'stock'       => $detail->stock(),
                    'price'       => $price,
                ]
            );
            $offer->images()->delete();

            foreach ($images as $url) {
                OfferImageModel::create([
                    'offer_id' => $offer->id,
                    'url'      => $url,
                ]);
            }
            Log::info("Oferta e imagens persistidas com sucesso. Oferta: {$detail->id()}");
        });
    }

    public function exists(string $offerId): bool{
        return OfferModel::where('marketplace_order_id', $offerId)->exists();
    }
}
