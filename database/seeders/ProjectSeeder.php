<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $types = Type::pluck('id');

        for ($i=0; $i < 20; $i++) {
            $newProject = new Project();
            $newProject->type_id = ($faker->randomElement($types));
            $newProject->title = ucfirst($faker->unique()->words(2, true));
            $newProject->description = $faker->paragraphs(10, true);
            $newProject->nPartecipants = $faker->randomNumber(2, false);
            $newProject->goals = json_encode($faker->randomElements(['goal1', 'goal2', 'goal3'], 2));
            $newProject->image = $faker->imageUrl(640, 480, 'project', true);
            $newProject->status = $faker->randomElement([null, 0, 1]);
            $newProject->budget = $faker->randomFloat(2, 1000, 10000);

            $newProject->save();
        }
    }
}
