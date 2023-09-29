<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\NodeVisitor\NameResolver;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function getCategoriesParent($keyword = '', $sql_order = '', $limit = ''){
        $query = $this->select( 'id', 'name', 'parent_id')
        ->where('parent_id', NULL)
        ->where('name', 'LIKE', '%' . $keyword . '%');
        if(!empty($sql_order)){
            $query->orderBy($sql_order);
        }
        if(!empty($limit)){
            $query->limit($limit);
        }
        return $query->get();
    }

    public function getCategoriesChild($parentID = ''){
        return $this->select( 'id', 'name')
        ->where('parent_id', $parentID)
        ->get();
    }
}
