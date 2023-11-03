<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\NodeVisitor\NameResolver;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function getCategoriesParent($keyword = '', $sql_order = '', $limit = ''){
        $query = $this->select( 'id', 'name', 'parent_id', 'created_at', 'updated_at')
        ->where('name', 'LIKE', '%' . $keyword . '%')
        ->where('parent_id', NULL);
        
        if(!empty($sql_order)){
            $query->orderBy($sql_order, 'DESC');
        }
        if(!empty($limit)){
            $query->limit($limit);
        }
        return $query->get();
    }

    public function getCategoriesChild($parentID = ''){
        return $this->select( 'id', 'name','created_at', 'updated_at')
        ->where('parent_id', $parentID)
        ->get();
    }

    public function getNameParent($data) {
        if($data->parent_id != NULL) {
            $nameParent = Category::where('parent_id', $data->parent_id)->select('name')->first();
            return $nameParent['name'];
        }else {
            return "Chưa có danh mục cha";
        }
    }
}
