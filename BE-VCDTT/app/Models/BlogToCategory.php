<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BlogToCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blogs_to_categories';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'cate_id',
        'blog_id',
    ];
}
