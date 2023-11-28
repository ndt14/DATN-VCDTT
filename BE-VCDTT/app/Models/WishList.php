<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wish_lists';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'tour_id',
    ];

    public function tour() {
        return $this->belongsTo(Tour::class);
    }
}
