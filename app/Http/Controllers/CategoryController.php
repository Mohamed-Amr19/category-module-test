<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with(['image'])->get();
        return response()->json($categories);
    }



    public function show($id)
    {
        $categories = Category::active()->with(['image'])->findOrFail($id);
        return response()->json($categories);
    }


    public function destroy($id)
    {
        $categories = Category::find($id);
        $categories->delete();
        return response()->json(['message' => __('Deleted if existed.')]);

    }
}
