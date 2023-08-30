<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $data = Category::orderBy("name", "asc")->get();
        $data = $data->map(function ($item) {
            return [
                "id" => $item->id,
                "name" => $item->name,
            ];
        });
        return response()->json([
            "data" => $data,
        ]);
    }
}
