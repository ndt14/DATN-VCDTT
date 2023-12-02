<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'ratings';

    protected $fillable = [
        'user_name',
        'user_id',
        'content',
        'admin_answer',
        'tour_id',
        'star'
    ];

    public function tour() {
        return $this->belongsTo(Tour::class)->withTrashed();
    }
}
