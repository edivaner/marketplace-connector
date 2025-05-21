<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\OfferImageModel;

class OfferModel extends Model
{
    protected $table = 'offers';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'marketplace_order_id',
        'title',
        'description',
        'status',
        'stock',
        'price',
    ];

    protected static function boot(): void{
        parent::boot();

        // Gera UUID automaticamente ao criar
        static::creating(function (self $model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relação 1:N com OfferImage
     */
    public function images(){
        return $this->hasMany(OfferImageModel::class, 'offer_id', 'id');
    }
}
