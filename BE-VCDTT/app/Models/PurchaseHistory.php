<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;

    protected $table = 'purchase_histories';

    protected $fillable = [
        'user_id',
        // 'user_info',

        // hotfix
        'name',
        'email',
        'phone_number',
        'address',
        'gender',

        'tour_name',
        'tour_duration',
        'tour_child_price',
        'child_count',
        'tour_adult_price',
        'adult_count',
        'tour_sale_percentage',
        'tour_start_destination',
        'tour_end_destination',
        'tour_location',
        'coupon_info',
        'coupon_percentage',
        'refund_percentage',
        'coupon_fixed',
        'tour_start_time',
        'tour_end_time',
        'payment_status',
        'purchase_status',
    ];
}
