<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $types = [
            ['name' => 'Operational', 'color' => '#FF5733'],
            ['name' => 'Tactical', 'color' => '#33FF57'],
            ['name' => 'Strategic', 'color' => '#5733FF'],
            ['name' => 'Upgrade', 'color' => '#FFFF33'],
            ['name' => 'Maintenance', 'color' => '#33FFFF'],
        ];

        foreach ($types as $typeData) {
            Type::create($typeData);
        }
    }
}
