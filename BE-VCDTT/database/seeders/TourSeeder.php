<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        for ($i = 1; $i < 20; $i++) {
            DB::table('tours')->insert([
                'name' => $faker->word(),
                'duration' => $faker->randomDigit(),
                'child_price' => $faker->randomNumber(true, 6),
                'adult_price' => $faker->randomNumber(true, 6),
                'sale_percentage' => $faker->randomNumber(true, 2),
                'start_destination' =>  $faker->word(),
                'end_destination' => $faker->word(),
                'tourist_count' => $faker->randomNumber(2),
                'details' => $faker->sentence(7),
                'location' => $faker->sentence(),
                'exact_location' => $faker->sentence(10),
                'main_img' => $faker->imageUrl(),
                'status' => 1,
                'view_count' => $faker->randomNumber(5),
            ]);
        }
    }
}
