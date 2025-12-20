<?php

namespace VivekMistry\InventoryCore\Tests\Feature;

use VivekMistry\InventoryCore\Tests\TestCase;
use VivekMistry\InventoryCore\Tests\Models\Product;
use VivekMistry\InventoryCore\Models\InventoryWarehouse;

class WarehouseTest extends TestCase
{
    public function test_stock_isolated_by_warehouse()
    {
        $warehouse = InventoryWarehouse::create([
            'name' => 'Main Warehouse',
            'code' => 'MAIN',
            'is_default' => true,
        ]);

        $product = Product::factory()->create();

        $product->addStock(50, warehouseId: $warehouse->id);

        $this->assertEquals(50, $product->availableStock());
    }
}
