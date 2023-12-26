<?php

namespace App\Http\Controllers;

use App\Models\comments;

use App\Models\Post;
use Illuminate\Http\Request;

class commentController extends Controller
{
    public function createComment(Request $request,$post_id){
        $post = Post::findOrFail($post_id);
        $commentData = $request->only('content');

        if(auth()->check()){
            $commentData['user_id']=auth()->id();
        }else{
            $commentData['guest_id']=uniqid('guest_',true);
        }
        $comment = $post->comments()->create($commentData);

        return response()->json($comment);
    }
}
