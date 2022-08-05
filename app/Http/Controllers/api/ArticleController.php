<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Auth;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::withCount('comments')->latest()->paginate();

        if (count($articles) == 0) {
            return response($articles, 204);
        }

        return response($articles, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->load('user')->load('comments.user');

        return response($article, 200);
    }

    public function destroy(Article $article)
    {
        $article->comments()->delete();
        $article->delete();

        return response(['deleted'=>true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        dd(Auth::check());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $article->title = $validated['title'];
        $article->content = $validated['content'];
        //$article->user_id = Auth::id();

        $article->save();

        return response(['update'=>true]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $article = new Article;

        $article->title = $validated['title'];
        $article->content = $validated['content'];
        $article->user_id = Auth::user()->id;

        $article->save();

        return response(['created'=>true]);
    }
}
