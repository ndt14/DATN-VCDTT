<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TourToCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tours_to_categories';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'cate_id',
        'tour_id',
    ];


}
