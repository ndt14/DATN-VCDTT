<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourToCategory extends Model
{
    use HasFactory;

    protected $table = 'tour_to_categories';

    protected $fillable = [
        'cate_id',
        'tour_id',
    ];
}
