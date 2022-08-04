<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;

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
}
