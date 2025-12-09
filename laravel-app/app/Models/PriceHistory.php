<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    protected $table = 'prices_history';

    protected $fillable = [
        'commodity_id',
        'price_value',
        'date_recorded',
        'recorded_by_id',
    ];

    protected $casts = [
        'date_recorded' => 'datetime',
    ];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }
}
