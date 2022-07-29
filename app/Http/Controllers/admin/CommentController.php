<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('admin.edit_comment', ['comment' => $comment]);
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

        return redirect(route('dashboard.article.show', $comment->article_id));
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

        return redirect(route('dashboard.article.show', $comment->article_id));
    }
}
