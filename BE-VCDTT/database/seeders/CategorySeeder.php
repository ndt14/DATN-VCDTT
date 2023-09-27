<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        for ($i = 1; $i < 20; $i++) {
            DB::table('categories')->insert([
                'name' => 'dcm' . $i,
                'parent_id' => $faker->randomDigit()
            ]);
        }
    }
}
