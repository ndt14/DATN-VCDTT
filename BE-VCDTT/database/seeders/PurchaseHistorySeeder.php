<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PurchaseHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        for ($i = 1; $i < 20; $i++) {
            DB::table('purchase_histories')->insert([
                'user_id' => $faker->numberBetween(1,20),
                'user_info' => $faker->sentence(),
                'tour_name' => $faker->word(),
                'tour_duration' => $faker->randomDigit(),
                'tour_child_price' => $faker->randomNumber(true, 6),
                'child_count' => $faker->randomNumber(2),
                'tour_adult_price' => $faker->randomNumber(true, 6),
                'adult_count' => $faker->randomNumber(2),
                'tour_sale_percentage' => $faker->randomNumber(true, 2),
                'tour_start_destination' => $faker->word(),
                'tour_end_destination' => $faker->word(),
                'tour_location' => $faker->sentence(),
                'coupon_info' => $faker->sentence(),
                'coupon_percentage' => $faker->randomNumber(true, 2),
                'refund_percentage' => $faker->randomNumber(true, 2),
                'coupon_fixed' => $faker->randomNumber(true, 5),
                'tour_start_time' => $faker->dateTime(),
                'tour_end_time' => $faker->dateTime()
            ]);
        }
    }
}
