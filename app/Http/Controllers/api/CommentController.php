<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:App\Models\Article,id',
            'content' => 'required|string|max:2000',
            'pseudo' => [
                Rule::excludeIf(Auth::check()),
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                Rule::excludeIf(Auth::check()),
                'required',
                'email',
                'max:255',
            ],
        ]);

        $comment = new Comment;
        $comment->article_id = $validated['article_id'];
        $comment->content = $validated['content'];

        if (Auth::check()) {
            $comment->user_id = Auth::user()->id;
        } else {
            $comment->pseudo = $validated['pseudo'];
            $comment->email = $validated['email'];
        }

        $comment->save();

        return response($comment, 201);
    }
}
