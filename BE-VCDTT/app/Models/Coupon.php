<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'coupons';

    protected $fillable = [
        'name',
        'code',
        // 'description',
        'start_date',
        'expiration_date',
        'tour_id',
        'cate_id',
        'percentage_price',
        'fixed_price',
        'status',
    ];

    protected static function booted()
    {
        static::retrieved(function ($coupon) {
            $now = time();

            if ($coupon->start_date && $now < strtotime($coupon->start_date)) {
                $coupon->status = 1;
            } elseif ($coupon->expiration_date && $now >= strtotime($coupon->start_date) && $now <= strtotime($coupon->expiration_date)) {
                $coupon->status = 2;
            } elseif ($coupon->expiration_date && $now > strtotime($coupon->expiration_date)) {
                $coupon->status = 3;
            }
            $coupon->save();
        });
    }

    public function tour() {
        return $this->belongsTo(Tour::class)->withTrashed();
    }
    public function cate() {
        return $this->belongsTo(Category::class)->withTrashed();
    }
}
