<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('article', $validated['article_id'])->with('success', 'Votre commentaire a bien été ajouté.');
    }
}
