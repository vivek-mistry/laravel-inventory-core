<?php

namespace VivekMistry\InventoryCore\Tests\Feature;

use VivekMistry\InventoryCore\Tests\TestCase;
use VivekMistry\InventoryCore\Tests\Models\Product;
use VivekMistry\InventoryCore\Events\LowStockDetected;
use Illuminate\Support\Facades\Event;

class LowStockEventTest extends TestCase
{
    public function test_low_stock_event_is_dispatched()
    {
        Event::fake();

        $product = Product::factory()->create();

        $product->addStock(10);
        $product->reduceStock(6);

        Event::assertDispatched(LowStockDetected::class);
    }
}
