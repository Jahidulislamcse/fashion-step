<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Fabric;
use App\Models\FabricStock;
use App\Models\FabricBarcode;
use App\Models\Note;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::factory(5)->create()->each(function ($supplier) {
            Fabric::factory(rand(1,3))->create(['supplier_id' => $supplier->id])->each(function ($fabric) {
                FabricStock::factory(rand(1,3))->create(['fabric_id' => $fabric->id]);
                FabricBarcode::create([
                    'fabric_id' => $fabric->id,
                    'barcode_value' => 'FAB-' . strtoupper(\Illuminate\Support\Str::random(10)),
                    'generated_by' => 1,
                ]);
                Note::factory()->create([
                    'noteable_type' => Fabric::class,
                    'noteable_id' => $fabric->id,
                    'user_id' => 1,
                ]);
            });

            Note::factory()->create([
                'noteable_type' => Supplier::class,
                'noteable_id' => $supplier->id,
                'user_id' => 1,
            ]);
        });
    }
}
