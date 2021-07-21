<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:categories,name|max:255'
        ]);

        Category::create([
            'name' => $request->name,
        ]);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $validateData = $request->validate([
            'name' => [
                "required", "max:255",
                Rule::unique('categories')->ignore($category->id, 'id')
            ]
        ]);

        $category->update($validateData);
        $category->save();
    }

    public function destroy(Category $category)
    {
        $category->delete();
    }
}
