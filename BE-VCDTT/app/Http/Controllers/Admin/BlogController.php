<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = trim($request()->keyword);
        $sql_where ='';
        // $sql_where=' AND delete_at IS NULL';
        if(!empty($keyword)){
            $sql_where .= ' AND tour_name LIKE %{$keyword}%';
        }
        $sql_order =' ORDER BY DESC';
        $sql_limit =' LIMIT 9';
        $blog = DB::select('select * from blos where 1'.$sql_where.$sql_order.$sql_limit);
        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = Blog::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
