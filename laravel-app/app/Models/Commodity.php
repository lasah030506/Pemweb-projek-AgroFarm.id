<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'price',
        'image_path',
    ];

    public function pricesHistory()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
