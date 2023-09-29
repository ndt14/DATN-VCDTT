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
                'start_date' => $faker->dateTimeBetween('- 1 year', 'now'),
                'end_date' => $faker->dateTimeBetween('now' ,'+ 1 year'),
                'tour_id' => $faker->numberBetween(1,20),
                'cate_id' => $faker->numberBetween(1,20),
                'percentage_price' => $faker->randomNumber(true,2),
                'fixed_price' => $faker->randomNumber(true,6),
                'status' => 1,
            ]);
        }
    }
}
