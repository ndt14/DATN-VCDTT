<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'tour_id',
        'cate_id',
        'percentage_price',
        'fixed_price',
        'status',
    ];
}
