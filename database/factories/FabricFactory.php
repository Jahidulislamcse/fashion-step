<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;

class FabricFactory extends Factory
{
    protected $model = \App\Models\Fabric::class;

    public function definition()
    {
        $productionTypes = ['Sample Yardage', 'SMS', 'Bulk'];

        return [
            'supplier_id' => Supplier::factory(),
            'fabric_no' => strtoupper($this->faker->unique()->bothify('FAB###')),
            'composition' => $this->faker->word,
            'gsm' => $this->faker->numberBetween(50, 500),
            'qty' => $this->faker->numberBetween(10, 200),
            'cuttable_width' => $this->faker->numberBetween(30, 60) . ' cm',
            'production_type' => $this->faker->randomElement($productionTypes),
            'construction' => $this->faker->word,
            'color_pantone_code' => strtoupper($this->faker->bothify('C###')),
            'weave_type' => $this->faker->word,
            'finish_type' => $this->faker->word,
            'dyeing_method' => $this->faker->word,
            'printing_method' => $this->faker->word,
            'lead_time' => $this->faker->numberBetween(5, 30),
            'moq' => $this->faker->numberBetween(50, 500),
            'shrinkage' => $this->faker->randomFloat(2, 0, 5),
            'remarks' => $this->faker->sentence,
            'fabric_selected_by' => $this->faker->name,
            'image_path' => null,
            'added_by' => 1,
            'updated_by' => 1,
        ];
    }
}
