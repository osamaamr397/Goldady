<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class PostController extends Controller
{
   public function index() : \Illuminate\Http\JsonResponse
   {
       $posts = Post::all();
       if (count($posts) == 0) {
           return response()->json(['message' => 'No posts found'], 404);
       }
       return response()->json($posts);
   }
   public function show($id)
   {
       $post = Post::find($id);
         if (!$post) {
              return response()->json(['error' => 'Post not found'], 404);
         }
       return response()->json($post);
   }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required',
            ]);
            $category = Category::find($request->category_id);
            if (!$category) {
                return response()->json(['error' => 'Invalid category ID'], 400);
            }

            $user_id = auth()->user()->id; 

            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->category_id = $request->category_id;
            $post->user_id = $user_id; 
            $post->save();

            
            Log::info('Post created', ['post_id' => $post->id, 'user_id' => $user_id]);
            

           

            return response()->json($post);
        } catch (\Exception $e) {
            Log::error('Error creating post', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required',
            ]);

            $post = Post::find($id);
            if (!$post) {
                return response()->json(['error' => 'post not exist'], 400);
            }
            $category = Category::find($request->category_id);
            if (!$category) {
                return response()->json(['error' => 'Invalid category ID'], 400);
            }

            $post->title = $request->title;
            $post->content = $request->content;
            $post->category_id = $request->category_id;
            $user_id = auth()->user()->id;
            $post->user_id = $user_id;
            $post->save();
            Log::info('Post updated', ['post_id' => $post->id, 'user_id' => auth()->user()->id]);

            return response()->json($post);
        } catch (\Exception $e) {
            Log::error('Error updating post', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function destroy($id) : \Illuminate\Http\JsonResponse
    {
        try {
            $post = Post::find($id);
            if (!$post) {
                return response()->json(['error' => 'post not exist'], 400);
            }
            $post->delete();
            Log::info('Post deleted', ['post_id' => $id, 'user_id' => auth()->user()->id]);
            return response()->json(['message' => 'Post deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function getPostsByCategory($id): \Illuminate\Http\JsonResponse
    {
        try {
            $category = Category::find($id);
            $posts = $category->posts;
            if (count($posts) == 0) {
                return response()->json(['message' => 'No posts found for this category'], 404);
            }
            
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
}
