<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopify_id',
        'title',
        'description',
        'price',
        'inventory_quantity',
        'status',
        'synced_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'synced_at' => 'datetime',
    ];
}
