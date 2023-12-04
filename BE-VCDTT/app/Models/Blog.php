<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'author',
        'short_desc',
        'description',
        'main_img',
        'view_count',
        'status',
    ];
    public function categories() {
        return $this->belongsToMany(Category::class,'blogs_to_categories','blog_id','cate_id')->withTrashed();;
    }
}
