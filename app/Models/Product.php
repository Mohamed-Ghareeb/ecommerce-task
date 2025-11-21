<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'status',
    ];

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    protected static function booted()
    {
        static::saving(function ($product) {
            $product->status = $product->stock == 0 ? ProductStatus::OUT_OF_STOCK : ProductStatus::IN_STOCK;
        });
    }
}
