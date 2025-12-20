<?php

namespace VivekMistry\InventoryCore\Tests\Feature;

use VivekMistry\InventoryCore\Tests\TestCase;
use VivekMistry\InventoryCore\Tests\Models\Product;

class StockTest extends TestCase
{
    public function test_stock_can_be_added_and_reduced()
    {
        $product = Product::factory()->create();

        $product->addStock(100);
        $this->assertEquals(100, $product->availableStock());

        $product->reduceStock(40);
        $this->assertEquals(60, $product->availableStock());
    }
}
