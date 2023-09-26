<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    use HasFactory;

    protected $table = 'seos';

    protected $fillable = [
        'name',
        'root_name',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'seo_tags'
    ];
}
