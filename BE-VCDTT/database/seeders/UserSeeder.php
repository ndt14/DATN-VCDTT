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
        $check = DB::table('users')->where('id',1)->first();
        if(isset($check->name)){
            User::factory()->count(5)->create();
        }else{
            DB::table('users')->insert([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'phone'=> '0932284064',
                'address' => 'Hà Nội',
                'role' => '1',
                'password' => Hash::make('123456'),
        ]);
        }
    }
}
