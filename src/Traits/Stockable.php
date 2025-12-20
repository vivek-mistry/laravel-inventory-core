<?php

namespace VivekMistry\InventoryCore\Traits;

use VivekMistry\InventoryCore\Facades\Inventory;
use VivekMistry\InventoryCore\Models\InventoryWarehouse;

trait Stockable
{
    public function stock($warehouseId = null)
    {
        $warehouseId ??= InventoryWarehouse::where('is_default', true)->value('id');

        return $this->morphOne(
            \VivekMistry\InventoryCore\Models\InventoryStock::class,
            'stockable'
        )->where('warehouse_id', $warehouseId);
    }

    public function addStock(int $qty, $warehouseId = null, array $meta = [])
    {
        return Inventory::add($this, $qty, $warehouseId, $meta);
    }

    public function reduceStock(int $qty, array $meta = [])
    {
        return Inventory::reduce($this, $qty, $meta);
    }

    public function availableStock($warehouseId = null): int
    {
        $stock = $this->stock($warehouseId)->first();

        if (! $stock) {
            return 0;
        }

        return $stock->quantity - $stock->reserved_quantity;
    }

    public function reserveStock(int $qty, $warehouseId = null, array $meta = [])
    {
        return Inventory::reserve($this, $qty, $warehouseId, $meta);
    }

    public function releaseStock(int $qty, $warehouseId = null, array $meta = [])
    {
        return Inventory::release($this, $qty, $warehouseId, $meta);
    }

    public function reservedStock($warehouseId = null): int
    {
        return $this->stock($warehouseId)->value('reserved_quantity') ?? 0;
    }
}
