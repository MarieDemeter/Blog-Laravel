<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;
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
        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:App\Models\Article,id',
            'content' => 'required|string|max:5000',
        ]);

        $comment->content = $validated['content'];
        $comment->user_id = Auth::user()->id;

        $comment->save();

        return response(['update'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response(['deleted'=>true]);
    }
}
