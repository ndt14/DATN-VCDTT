<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tour extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
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
        'view_count',
        'includes',
        'creator'
    ];
    protected $categoriesArray;

    public function categories() {
        return $this->belongsToMany(Category::class,'tours_to_categories','tour_id','cate_id')->withTrashed();;
    }

    public function coupons() {
        return $this->hasMany(Coupon::class)->withTrashed();
    }

    public function setCategoriesArray(array $categoriesArray)
    {
        $this->categoriesArray = $categoriesArray;
    }

    public function purchase()
    {
        return $this->hasMany(PurchaseHistory::class)->withTrashed();
    }

    public function toSearchableArray()
    {
        $tour = Tour::find($this->id);
        $categories = new Category();
        $rating = Rating::where('tour_id', $tour->id)->get();
        if(count($rating)>0){
            $cout_star=0;
            foreach($rating as $value){
                $cout_star+=$value->star;
            }
            $avg_star = round($cout_star/count($rating),1);
        }else{
            $avg_star = 0;
        }

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
            'pathway' => string_truncate($tour->pathway, 5000),
            'view_count' => $tour->view_count,
            'rating' => $avg_star,
            'created_at' => time_format($tour->created_at),
            'updated_at' => time_format($tour->updated_at),
        ];
        $data['category']['lvl0'] = [];
        $data['category']['lvl1'] = [];
        if(is_array($this->categoriesArray) || is_object($this->categoriesArray)) {
            foreach($this->categoriesArray as $cate){
                if(Category::where('id', $cate)->where('parent_id', null)->exists()){
                    $categoriesParent = Category::where('id', $cate)->first();
                    $categoriesParent->child = $categories->getCategoriesChild($cate);
                    $data['category']['lvl0'][] = $categoriesParent->name;
                    foreach ($categoriesParent->child as $child) {
                        $data['category']['lvl1'][] = $categoriesParent->name.' > '. $child->name;
                    }
                    $data['parent_category'][] = $categoriesParent->name;
                }
                else{
                        
                        $categoriesChild = Category::withTrashed()->find($cate);
                        $parentList = Category::where('id', $categoriesChild->parent_id)->get();
                        foreach($parentList as $parent){
                            if(!in_array( $parent->name.' > '. $categoriesChild->name,$data['category']['lvl1'])){
                                $data['category']['lvl1'][] = $parent->name.' > '. $categoriesChild->name;
                            }
                            if(!in_array( $parent->name,$data['category']['lvl0'])){
                                $data['category']['lvl0'][] = $parent->name;
                            }
                        }
                    }

            }
        }
        return $data;
    }
}
