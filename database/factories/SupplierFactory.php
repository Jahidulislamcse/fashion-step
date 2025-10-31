<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class SupplierFactory extends Factory
{
    protected $model = \App\Models\Supplier::class;

    public function definition()
    {
        return [
            'country' => $this->faker->country,
            'company_name' => $this->faker->company,
            'code' => strtoupper($this->faker->unique()->lexify('SUP???')),
            'email' => $this->faker->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'rep_name' => $this->faker->name,
            'rep_email' => $this->faker->email,
            'rep_phone' => $this->faker->phoneNumber,
            'added_by' => 1,
            'updated_by' => 1,
        ];
    }
}
