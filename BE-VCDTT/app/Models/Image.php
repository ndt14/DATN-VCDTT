<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'images';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'type',
        'url',
        'tour_id',
        'blog_id',
    ];
}
