<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductData extends Model
{
    /** @use HasFactory<\Database\Factories\ProductDataFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_gram',
        'stock',
        'low_stock_threshold',
    ];

    protected function casts(): array
    {
        return [
            'price_per_gram' => 'decimal:2',
            'stock' => 'integer',
            'low_stock_threshold' => 'integer',
        ];
    }
}
