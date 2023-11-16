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
                'user_id' => $faker->numberBetween(1, 20),
                // 'user_info' => $faker->sentence(3),

                // hotfix
                'name' => 'Example name ' . $i,
                'email' => $faker->email(),
                'address' => $faker->address(),
                'phone_number' => $faker->phoneNumber(),
                'gender' => $faker->numberBetween(1, 3),
                'transaction_id' => $faker->randomNumber(8, true),
                'suggestion' => $faker->sentence(20),
                'tour_id' => $faker->numberBetween(1, 20),
                'tour_name' => $faker->sentence(10),
                'tour_duration' => $faker->randomDigit(),
                'tour_child_price' => $faker->randomNumber(6, true),
                'child_count' => $faker->randomNumber(1),
                'tour_adult_price' => $faker->randomNumber(6, true),
                'adult_count' => $faker->randomNumber(1),
                'tour_sale_percentage' => $faker->randomNumber(2, true),
                'tour_start_destination' => $faker->sentence(3),
                'tour_end_destination' => $faker->sentence(3),
                'tour_location' => $faker->sentence(),
                'coupon_name' => $faker->sentence(),
                'coupon_percentage' => $faker->randomNumber(2, true),
                'refund_percentage' => $faker->randomNumber(2, true),
                'coupon_fixed' => $faker->randomNumber(5, true),
                'tour_start_time' => $faker->dateTimeBetween('- 1 year', 'now'),
                'tour_end_time' => $faker->dateTimeBetween('now', '+ 1 year'),
                'comfirm_click' => $faker->numberBetween(1, 2),
                'purchase_method' => $faker->numberBetween(1, 2),
                'payment_status' => $faker->numberBetween(1, 2),
                'purchase_status' => $faker->numberBetween(1, 8),
                'tour_status' => $faker->numberBetween(1, 3),
            ]);
        }
    }
}
