<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Fabric;

class FabricStockFactory extends Factory
{
    protected $model = \App\Models\FabricStock::class;

    public function definition()
    {
        $transactionType = $this->faker->randomElement(['in', 'out']);
        return [
            'fabric_id' => Fabric::factory(),
            'transaction_type' => $transactionType,
            'quantity' => $this->faker->numberBetween(5, 100),
            'reference' => $this->faker->bothify('REF###'),
            'remarks' => $this->faker->sentence,
            'created_by' => 1,
        ];
    }
}
