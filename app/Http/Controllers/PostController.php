<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function approvePost(Request $request){
        if(auth()->check() && auth()->user()->is_admin){
            $post = Post::find($request->id);
            $post->status='approved';
            $post->update();
            return response()->json(['message'=>'post approved successfully']);
        }else{
            return response()->json(['post approval unsuccessful']);
        }
    }
    public function showApproved(Request $request){
        $post = Post::all($request->status=='approved');
        return response()->json($post);
    }
    public function showUnapproved(Request $request){
        $post = Post::all($request->is_admin=='unapproved');
        return response()->json($post);
    }
    public function createPost(Request $request){
        if(!auth()->check()){
            return response()->json(['message'=>['You must be logged in to create the post']]);
        }
        $post = new Post;
        $post->title=$request->title;
        $post->content=$request->content;

        $post->save();
        return response()->json(['message'=>'post has been created successfully'],200);
    }
    public function updatePost(Request $request){
        $post = Post::find($request->title);
        if(!auth()->check()){
            return response()->json(['message'=>['You must be logged in to create the post']]);
        }
        if($post->fails()){
            return response()->json(['message'=>'there is no post with this title'],404);
        }else{
            $post->title=$request->title;
            $post->content=$request->content;

            $post->update();
            return response()->json(['message'=>'post has been updated successfully'],200);
        }
    }

    public function deletePost(Request $request){
        $post = Post::find($request->title);
        if($post->fails()){
            return response()->json(['message'=>'there is no post with this title'],404);
        }else{
            $post->delete();
            return response()->json(['message'=>'Post has been deleted successfully']);
        }
    }
}
