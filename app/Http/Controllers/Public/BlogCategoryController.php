<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(){
        return response()->json([
            'data' => Category::latest()->get(['id', 'name'])
        ]);
    }
}
