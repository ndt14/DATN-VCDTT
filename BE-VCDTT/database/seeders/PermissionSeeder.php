<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            0 => [
                'id' => 1,
                'name' => 'add tour',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            1 => [
                'id' => 2,
                'name' => 'edit tour',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            2 => [
                'id' => 3,
                'name' => 'delete tour',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            3 => [
                'id' => 4,
                'name' => 'access tour',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            4 => [
                'id' => 5,
                'name' => 'edit bill',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            5 => [
                'id' => 6,
                'name' => 'delete bill',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            6 => [
                'id' => 7,
                'name' => 'access bill',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            7 => [
                'id' => 8,
                'name' => 'add category',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            8 => [
                'id' => 9,
                'name' => 'edit category',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            9 => [
                'id' => 10,
                'name' => 'delete category',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            10 => [
                'id' => 11,
                'name' => 'access category',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            11 => [
                'id' => 12,
                'name' => 'add discount',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            12 => [
                'id' => 13,
                'name' => 'edit discount',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            13 => [
                'id' => 14,
                'name' => 'delete discount',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            14 => [
                'id' => 15,
                'name' => 'access discount',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            15 => [
                'id' => 16,
                'name' => 'add account',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            16 => [
                'id' => 17,
                'name' => 'edit account',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            17 => [
                'id' => 18,
                'name' => 'delete account',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            18 => [
                'id' => 19,
                'name' => 'access account',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            19 => [
                'id' => 20,
                'name' => 'add faq',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            20 => [
                'id' => 21,
                'name' => 'edit faq',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            21 => [
                'id' => 22,
                'name' => 'delete faq',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            22 => [
                'id' => 23,
                'name' => 'access faq',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            23 => [
                'id' => 24,
                'name' => 'add post',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            24 => [
                'id' => 25,
                'name' => 'edit post',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            25 => [
                'id' => 26,
                'name' => 'delete post',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            26 => [
                'id' => 27,
                'name' => 'access post',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            27 => [
                'id' => 28,
                'name' => 'reply review',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            28 => [
                'id' => 29,
                'name' => 'delete review',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            29 => [
                'id' => 30,
                'name' => 'access review',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            30 => [
                'id' => 31,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            31 => [
                'id' => 32,
                'name' => 'access settings',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('permissions')->insert($data);
    }
}
