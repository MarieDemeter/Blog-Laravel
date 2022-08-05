<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::delete('/dashboard/articles/{article}', [ArticleController::class, 'destroy'])->name('api.dashboard.articles.destroy');
    Route::post('/dashboard/create_article', [ArticleController::class, 'store'])->name('api.dashboard.article.store');
    Route::put('/dashboard/article/{article}', [ArticleController::class, 'update'])->name('api.dashboard.article.update');
    Route::put('/dashboard/comment/{comment}', [CommentController::class, 'update'])->name('api.dashboard.comment.update');
    Route::delete('/dashboard/comment/{comment}', [CommentController::class, 'destroy'])->name('api.dashboard.comment.destroy');
//});

Route::get('/articles', [ArticleController::class, 'index'])->name('api.home');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('api.articles');
Route::post('/comments', [CommentController::class, 'store'])->name('api.comments.store');
