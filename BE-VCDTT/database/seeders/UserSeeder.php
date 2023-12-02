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
        $faker = Factory::create();
            DB::table('users')->insert([
                'name' => 'Quản Trị Viên',
                'email' => 'thinh1420003@gmail.com',
                'password' => Hash::make('123456'),
                'phone_number' => $faker->phoneNumber(),
                'date_of_birth' => $faker->date(),
                'address' => 'số 1 Trịnh Văn Bô, Nam Từ Liêm, Hà Nội',
                'gender' => 1,
                'image' => $faker->imageUrl(null, 640, 480),
                'status' => 1,
                'is_admin' => 1,
            ]);
    }
}
