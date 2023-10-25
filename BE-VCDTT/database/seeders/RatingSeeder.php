<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        for ($i = 1; $i < 20; $i++) {
            DB::table('ratings')->insert([
                'star' => $faker->numberBetween(1,5),
                'user_id' => $faker->numberBetween(1, 20),
                'user_name' => $faker->name(),
                'content' => $faker->sentence(10),
                'admin_answer' => $faker->sentence(10),
                'tour_id' => $faker->numberBetween(1, 20),
            ]);
        }
    }
}
