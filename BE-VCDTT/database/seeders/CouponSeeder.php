<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        for ($i = 1; $i < 20; $i++) {
            DB::table('coupons')->insert([
                'name' => 'dcm' . $i,
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur quae e sequi sed dolores tempore illum obcaecati voluptatem libero minus voluptatibus? Illum facilis quod natus esse fugiat excepturi molestiae nobis?',
                'start_date' => $faker->dateTime(),
                'end_date' => $faker->dateTime(),
                'tour_id' => $faker->randomDigit(),
                'cate_id' => $faker->randomDigit(),
                'percentage_price' => $faker->randomNumber(true,2),
                'fixed_price' => $faker->randomNumber(true,6),
                'status' => 1,
            ]);
        }
    }
}
