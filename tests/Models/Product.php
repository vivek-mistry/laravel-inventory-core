<?php

namespace VivekMistry\InventoryCore\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use VivekMistry\InventoryCore\Traits\Stockable;
use VivekMistry\InventoryCore\Tests\Database\Factories\ProductFactory;

class Product extends Model
{
    use Stockable, HasFactory;

    protected $table = 'products';
    protected $guarded = [];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
