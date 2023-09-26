<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours';

    protected $fillable = [
        'name',
        'duration',
        'child_price',
        'adult_price',
        'sale_percentage',
        'start_destination',
        'end_destination',
        'tourist_count',
        'details',
        'location',
        'exact_location',
        'main_img',
        'status',
        'view_count',
    ];
}
