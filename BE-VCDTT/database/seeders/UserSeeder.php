<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        for ($i = 1; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => 'dcm' . $i,
                'email' => $faker->email(),
                'password' => Hash::make('123456'),
                'phone_number' => $faker->phoneNumber(),
                'date_of_birth' => $faker->date(),
                'address' => $faker->address(),
                'gender' => $faker->numberBetween(1,3),
                'image' => $faker->imageUrl(null, 640, 480),
                'status' => 1,
                'is_admin' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}
