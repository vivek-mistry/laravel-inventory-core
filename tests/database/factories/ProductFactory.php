<?php

namespace VivekMistry\InventoryCore\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use VivekMistry\InventoryCore\Tests\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
