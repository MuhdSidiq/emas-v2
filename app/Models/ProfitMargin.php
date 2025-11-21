<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfitMargin extends Model
{
    protected $fillable = [
        'name',
        'rate',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the margin multiplier (e.g., 0.5% = 1.005)
     */
    public function getMultiplier(): float
    {
        return 1 + ($this->rate / 100);
    }
}
