<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeyValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fixedItems = [
            [
                'name' => 'Ảnh logo chính',
                'key' => 'logo',
                'value' => 'img_url'
            ],
            [
                'name' => 'Ảnh logo favicon',
                'key' => 'favicon',
                'value' => 'img_url'
            ],
            [
                'name' => 'Tên website',
                'key' => 'webTitle',
                'value' => 'VCDTT'
            ],
            [
                'name' => 'Email website',
                'key' => 'email',
                'value' => 'admin@gmail.com'
            ],
            [
                'name' => 'Địa chỉ trụ sở',
                'key' => 'address',
                'value' => 'Hà nội'
            ],
            [
                'name' => 'Số điện thoại liên hệ',
                'key' => 'webPhoneNumber1',
                'value' => '0934234234'
            ],
            [
                'name' => 'Số điện thoại liên hệ khác',
                'key' => 'webPhoneNumber2',
                'value' => '0934234234'
            ],
            [
                'name' => 'Tên ngân hàng sử dụng',
                'key' => 'bankName',
                'value' => 'MBBank'
            ],
            [
                'name' => 'Tên tài khoản ngân hàng',
                'key' => 'bankAccountName',
                'value' => 'VCDTT'
            ],
            [
                'name' => 'Số tài khoản ngân hàng',
                'key' => 'bankAccountNumber' ,
                'value' => '942342523'
            ],
            [
                'name' => 'Ảnh banner',
                'key' => 'banner',
                'value' => 'img_url'
            ],
            [
                'name' => 'Tiêu đề meta (Meta title)',
                'key' => 'metaTitle',
                'value' => ''
            ],
            [
                'name' => 'Tác giả meta (Meta author)',
                'key' => 'metaAuthor',
                'value' => ''
            ],
            [
                'name' => 'Mô tả meta (Meta description)',
                'key' => 'metaDescription',
                'value' => ''
            ],
            [
                'name' => 'Từ khóa meta (Meta keyword)',
                'key' => 'metaKeyword',
                'value' => ''
            ],
            [
                'name' => 'Phân tích của Google',
                'key' => 'metaAnalytic',
                'value' => ''
            ],
        ];
            DB::table('key_value')->insert($fixedItems);
    }
}
