<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $category->updateOrFail($validated);
        return response()->json($category);
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $category = Category::create($validated);
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('admin');
        $category->deleteOrFail();
        return response()->json($category);
    }
}
