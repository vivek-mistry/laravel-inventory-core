<?php

namespace VivekMistry\InventoryCore\Events;

use VivekMistry\InventoryCore\Models\InventoryStock;

class LowStockDetected
{
    public function __construct(
        public InventoryStock $stock
    ) {}
}
