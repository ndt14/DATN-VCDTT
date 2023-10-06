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
                'name' => $faker->sentence(3),
                'duration' => $faker->randomDigit(),
                'child_price' => $faker->randomNumber(6,true),
                'adult_price' => $faker->randomNumber(6,true),
                'sale_percentage' => $faker->randomNumber(2,true),
                'start_destination' =>  $faker->sentence(3),
                'end_destination' => $faker->sentence(3),
                'tourist_count' => $faker->randomNumber(2),
                'details' => $faker->sentence(7),
                'location' => $faker->sentence(),
                'exact_location' => $faker->sentence(10),
                'pathway' => $faker->paragraph(10),
                'main_img' => $faker->imageUrl(),
                'status' => 1,
                'view_count' => $faker->randomNumber(5),
            ]);
        }
    }
}
