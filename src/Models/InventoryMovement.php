<?php

namespace VivekMistry\InventoryCore\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $guarded = [];

    protected $casts = [
        'meta' => 'array'
    ];

    public function stockable()
    {
        return $this->morphTo();
    }
}
