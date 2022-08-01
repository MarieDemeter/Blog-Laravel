<?php

use App\Http\Controllers\admin\ArticleController as AdminArticleController;
use App\Http\Controllers\admin\CommentController as AdminCommentController;
use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\json\ArticleController as JsonArticleController;
use App\Http\Controllers\json\CommentController as JsonCommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article');
Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');

Route::get('/json', [JsonArticleController::class, 'index'])->name('home.json');
Route::get('/json/article/{article}', [JsonArticleController::class, 'show'])->name('article.json');
Route::post('/json/comment', [JsonCommentController::class, 'store'])->name('comment.store.json');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/articles', [AdminArticleController::class, 'index'])->name('dashboard.articles');
    Route::get('/dashboard/create_article', [AdminArticleController::class, 'create'])->name('dashboard.article.create');
    Route::get('/dashboard/article/{article}', [AdminArticleController::class, 'show'])->name('dashboard.article.show');
    Route::post('/dashboard/create_article', [AdminArticleController::class, 'store'])->name('dashboard.article.store');
    Route::get('/dashboard/article/{article}/edit', [AdminArticleController::class, 'edit'])->name('dashboard.article.edit');
    Route::put('/dashboard/article/{article}', [AdminArticleController::class, 'update'])->name('dashboard.article.update');
    Route::delete('/dashboard/article/{article}', [AdminArticleController::class, 'destroy'])->name('dashboard.article.destroy');

    Route::get('/dashboard/comment/{comment}', [AdminCommentController::class, 'edit'])->name('dashboard.comment.edit');
    Route::put('/dashboard/comment/{comment}', [AdminCommentController::class, 'update'])->name('dashboard.comment.update');
    Route::delete('/dashboard/comment/{comment}', [AdminCommentController::class, 'destroy'])->name('dashboard.comment.destroy');

});

require __DIR__.'/auth.php';
