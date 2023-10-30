<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tour extends Model
{
    use HasFactory;
    use Searchable;

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
        'pathway',
        'main_img',
        'status',
        'view_count'
    ];
    protected $categoriesArray;

    public function setCategoriesArray(array $categoriesArray)
    {
        $this->categoriesArray = $categoriesArray;
    }

    public function toSearchableArray()
    {
        $tour = Tour::find($this->id);
        $data = [
            //tour
            'tour_id' => $tour->id,
            'name' => $tour->name,
            'main_img' => $tour->main_img,
            'duration' => $tour->duration,
            'child_price' => $tour->child_price,
            'adult_price' => $tour->adult_price,
            'sale_percentage' => $tour->sale_percentage,
            'start_destination' => $tour->start_destination,
            'end_destination' => $tour->end_destination,
            'tourist_count' => $tour->tourist_count,
            'details' => $tour->details,
            'location' => $tour->location,
            'exact_location' => $tour->exact_location,
            'pathway' => $tour->pathway,
            'view_count' => $tour->view_count,
            'created_at' => time_format($tour->created_at),
            'updated_at' => time_format($tour->updated_at),
            //category
            'cate_id' => $this->categoriesArray,
        ];
        return $data;
    }
}
