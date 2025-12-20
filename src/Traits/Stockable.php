<?php

namespace VivekMistry\InventoryCore\Traits;

use Inventory;

trait Stockable
{
    public function stock()
    {
        return $this->morphOne(
            \InventoryCore\Models\InventoryStock::class,
            'stockable'
        );
    }

    public function addStock(int $qty, $warehouseId = null, array $meta = [])
    {
        return Inventory::add($this, $qty, $warehouseId, $meta);
    }

    public function reduceStock(int $qty, array $meta = [])
    {
        return Inventory::reduce($this, $qty, $meta);
    }

    public function availableStock(): int
    {
        return Inventory::get($this);
    }

    public function reserveStock(int $qty, $warehouseId = null, array $meta = [])
    {
        return Inventory::reserve($this, $qty, $warehouseId, $meta);
    }

    public function releaseStock(int $qty, $warehouseId = null, array $meta = [])
    {
        return Inventory::release($this, $qty, $warehouseId, $meta);
    }

    public function reservedStock(): int
    {
        return $this->stock?->reserved_quantity ?? 0;
    }
}
