<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;
use App\Models\Fabric;

class NoteFactory extends Factory
{
    protected $model = \App\Models\Note::class;

    public function definition()
    {
        $models = [Supplier::class, Fabric::class];
        $noteableType = $this->faker->randomElement($models);
        return [
            'noteable_type' => $noteableType,
            'noteable_id' => $noteableType::factory(),
            'user_id' => 1,
            'body' => $this->faker->sentence,
        ];
    }
}
