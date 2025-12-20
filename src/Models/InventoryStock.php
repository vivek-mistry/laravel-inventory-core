<?php

namespace VivekMistry\InventoryCore\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    protected $guarded = [];

    public function stockable()
    {
        return $this->morphTo();
    }
}
