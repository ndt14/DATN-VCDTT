<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurchaseHistory extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $table = 'purchase_histories';
    protected $dates = ['deleted_at','tour_start_time','tour_end_time'];
    protected $casts = ['expired_at' => 'datetime'];


    protected $fillable = [
        'user_id',
        'tour_id',
        // 'user_info',

        // hotfix
        'name',
        'email',
        'phone_number',
        'address',
        'gender',
        'suggestion',
        'transaction_id',

        'tour_name',
        'tour_duration',
        'tour_child_price',
        'child_count',
        'tour_adult_price',
        'adult_count',
        'tour_start_destination',
        'tour_end_destination',
        'tour_location',
        'tour_sale_percentage',
        'coupon_name',
        'coupon_percentage',
        'coupon_fixed',
        'refund_percentage',
        'tour_start_time',
        'tour_end_time',
        'tour_image',
        'payment_term',
        'payment_privacy',

        'comfirm_click',
        'purchase_method',
        'payment_status',
        'purchase_status',
        'tour_status',
    ];
}
