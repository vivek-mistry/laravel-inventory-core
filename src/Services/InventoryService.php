<?php

namespace VivekMistry\InventoryCore\Services;

use VivekMistry\InventoryCore\Models\InventoryStock;
use VivekMistry\InventoryCore\Models\InventoryMovement;
use VivekMistry\InventoryCore\Models\InventoryWarehouse;
use VivekMistry\InventoryCore\Events\LowStockDetected;


class InventoryService
{
    public function add($model, int $qty, $warehouseId = null, array $meta = [])
    {
        $warehouse = $this->resolveWarehouse($warehouseId);

        $stock = InventoryStock::firstOrCreate(
            [
                'stockable_type' => get_class($model),
                'stockable_id'   => $model->id,
                'warehouse_id'   => $warehouse?->id,
            ],
            ['quantity' => 0, 'reserved_quantity' => 0]
        );

        $stock->increment('quantity', $qty);

        InventoryMovement::create([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
            'warehouse_id'   => $warehouse?->id,
            'type'           => 'in',
            'quantity'       => $qty,
            'meta'           => $meta,
        ]);

        return $stock->quantity;
    }

    /*public function add($model, int $qty, array $meta = [])
    {
        $stock = InventoryStock::firstOrCreate(
            [
                'stockable_type' => get_class($model),
                'stockable_id'   => $model->id,
            ],
            ['quantity' => 0]
        );

        $stock->increment('quantity', $qty);

        InventoryMovement::create([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
            'type'           => 'in',
            'quantity'       => $qty,
            'meta'           => $meta,
        ]);

        return $stock->quantity;
    }*/

    public function reduce($model, int $qty, array $meta = [])
    {
        $stock = InventoryStock::where([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
        ])->firstOrFail();

        if (!config('inventory.allow_negative_stock') && $stock->quantity < $qty) {
            throw new \Exception('Insufficient stock');
        }

        $stock->decrement('quantity', $qty);

        InventoryMovement::create([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
            'type'           => 'out',
            'quantity'       => $qty,
            'meta'           => $meta,
        ]);

        if ($stock->quantity <= config('inventory.low_stock_threshold')) {
            event(new LowStockDetected($stock));
        }

        return $stock->quantity;
    }

    public function get($model): int
    {
        return InventoryStock::where([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
        ])->value('quantity') ?? 0;
    }

    protected function resolveWarehouse($warehouseId = null)
    {
        if ($warehouseId) {
            return InventoryWarehouse::findOrFail($warehouseId);
        }

        return InventoryWarehouse::where('is_default', true)->first();
    }

    public function reserve($model, int $qty, $warehouseId = null, array $meta = [])
    {
        $warehouse = $this->resolveWarehouse($warehouseId);

        $stock = InventoryStock::where([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
            'warehouse_id'   => $warehouse?->id,
        ])->firstOrFail();

        $available = $stock->quantity - $stock->reserved_quantity;

        if ($available < $qty) {
            throw new \Exception('Insufficient available stock');
        }

        $stock->increment('reserved_quantity', $qty);

        InventoryMovement::create([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
            'warehouse_id'   => $warehouse?->id,
            'type'           => 'reserve',
            'quantity'       => $qty,
            'meta'           => $meta,
        ]);

        return true;
    }

    public function release($model, int $qty, $warehouseId = null, array $meta = [])
    {
        $warehouse = $this->resolveWarehouse($warehouseId);

        $stock = InventoryStock::where([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
            'warehouse_id'   => $warehouse?->id,
        ])->firstOrFail();

        $stock->decrement('reserved_quantity', $qty);

        InventoryMovement::create([
            'stockable_type' => get_class($model),
            'stockable_id'   => $model->id,
            'warehouse_id'   => $warehouse?->id,
            'type'           => 'release',
            'quantity'       => $qty,
            'meta'           => $meta,
        ]);

        return true;
    }

}
