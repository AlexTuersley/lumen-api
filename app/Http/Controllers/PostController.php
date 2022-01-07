<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Exception;

class PostController extends Controller
{
    public function index(){
        return Post::all();
    }

    public function store(Request $request){
        try{
            $this->validate($request, [
                'title' => 'required|string',
                'body' => 'required|string'
            ]);

            $post = new Post([
                'title' => $request->title,
                'body' => $request->body
            ]);
            $post->save();
            return response([
                'status' => 'success',
                'message' =>'Post Created'
            ]);
        }
        catch(Exception $e){
            return response([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request){
        try{

            $this->validate($request, [
                'title' => 'string',
                'body' => 'string'
            ]);

            $post = Post::findOrFail($request->post);
            $post->title =  $request->title;
            $post->body = $request->body;
            $post->save();
            return response([
                'status' => 'success',
                'message' =>'Post Updated'
            ]);
        }
        catch(Exception $e){
            return response([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request){
        try{
            $post = Post::findOrFail($request->post);
            $post->delete();
            return response([
                'status' => 'success',
                'message' =>'Post Deleted'
            ]);
        }
        catch(Exception $e){
            return response([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
