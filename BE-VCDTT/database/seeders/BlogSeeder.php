<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        for ($i = 1; $i < 20; $i++) {
            DB::table('blogs')->insert([
                'title' => 'dcm' . $i,
                'short_desc' => 'abc' . $i,
                'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Pariatur quae et, sequi sed dolores tempore, illum obcaecati voluptatem libero minus voluptatibus? Illum facilis, quod natus esse fugiat excepturi molestiae nobis?',
                'main_img' => $faker->randomDigit(),
                'view_count' => $faker->randomNumber(5,true),
                'status' => 1
            ]);
        }
    }
}
