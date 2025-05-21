<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferImageModel extends Model
{
    protected $table = 'offer_images';

    protected $fillable = [
        'offer_id',
        'url',
    ];

    // relacionamento esta aqui, verificar depois
    public function offer(){
        return $this->belongsTo(OfferModel::class, 'offer_id', 'id');
    }
}
