<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldPrice extends Model
{
    /** @use HasFactory<\Database\Factories\GoldPriceFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'price_per_troy_ounce',
        'price_per_gram',
        'currency',
        'source',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'price_per_troy_ounce' => 'decimal:2',
            'price_per_gram' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }
}
