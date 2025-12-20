<?php

namespace VivekMistry\InventoryCore\Tests\Feature;

use VivekMistry\InventoryCore\Tests\TestCase;
use VivekMistry\InventoryCore\Tests\Models\Product;

class ReservationTest extends TestCase
{
    public function test_reservation_prevents_overselling()
    {
        $product = Product::factory()->create();

        $product->addStock(10);
        $product->reserveStock(7);

        $this->assertEquals(3, $product->availableStock());

        $this->expectException(\Exception::class);
        $product->reserveStock(5);
    }
}
