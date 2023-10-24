<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TourToCategory extends Model
{
    use HasFactory, Searchable;
    protected $table = 'tours_to_categories';

    protected $fillable = [
        'cate_id',
        'tour_id',
    ];

    public function toSearchableArray()
    {
        $tour = Tour::find($this->tour_id);
        $category = Category::find($this->cate_id);
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
            'cate_id' => $this->cate_id,
            'cate_name' => $category->name,
            'cate_parent_id' => $category->parent_id
        ];
        return $data;
    }
}
