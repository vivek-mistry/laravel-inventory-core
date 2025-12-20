<?php

namespace VivekMistry\InventoryCore\Facades;

use Illuminate\Support\Facades\Facade;

class Inventory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'inventory';
    }
}
