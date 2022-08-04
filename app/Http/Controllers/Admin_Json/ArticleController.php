<?php

namespace App\Http\Controllers\Admin_Json;

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
        return view('Admin_Json.articles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin_Json.create_article');
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

        return redirect()->route('json.dashboard')->with('success', 'Votre article a bien été ajouté.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('Admin_Json.article');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('Admin_Json.edit_article');
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
        $validated = $request->validate([
            'article_id' => 'required|exists:App\Models\Article,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $article->title = $validated['title'];
        $article->content = $validated['content'];
        $article->user_id = Auth::user()->id;

        $article->save();

        return redirect(route('json.dashboard.articles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $comments = $article->comments;

        if ($comments) {
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }

        $article->delete();

        return redirect(route('json.dashboard.articles'));
    }
}
