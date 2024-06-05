<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if (count($categories) == 0) {
            return response()->json(['message' => 'No categories found'], 404);
        }
        return response()->json($categories);
    }
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($category);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $category = Category::create([
                'name' => $request->name,
            ]);

            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category'], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }
            
            $category->name = $request->name;
            $category->save();
            
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category'], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }
            $category->delete();
            
            return response()->json(['message' => 'Category deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category'], 500);
        }
    }
    
    public function getPostsByCategory($id)
    {
        $category = Category::find($id);

        $posts = $category->posts;

        
        return response()->json($posts);
    }
}
