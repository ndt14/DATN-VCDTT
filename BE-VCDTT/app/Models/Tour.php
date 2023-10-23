<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class Tour extends Model
{
    use HasFactory;
    // use Searchable;

    protected $table = 'tours';

    protected $fillable = [
        'name',
        'duration',
        'child_price',
        'adult_price',
        'sale_percentage',
        'start_destination',
        'end_destination',
        'tourist_count',
        'details',
        'location',
        'exact_location',
        'pathway',
        'main_img',
        'status',
        'view_count'
    ];
    // public function toSearchableArray()
    // {
    //     $array = $this->toArray();

    //     // Xác định các trường dữ liệu bạn muốn chỉ mục
    //     $customData = [
    //         'name' => $this->name,
    //         'duration' => $this->duration,
    //         'child_price' => $this->child_price,
    //         'adult_price' => $this->adult_price,
    //         // Thêm các trường dữ liệu khác mà bạn muốn tìm kiếm
    //     ];

    //     // Kết hợp các trường dữ liệu mà bạn muốn chỉ mục
    //     $array = array_merge($array, $customData);

    //     return $array;
    // }
}
