<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'speed',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customer_products')
            ->withPivot('start_date', 'end_date', 'status')
            ->withTimestamps();
    }
}
