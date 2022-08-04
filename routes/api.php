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

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::delete('/dashboard/articles/{article}', [ArticleController::class, 'destroy'])->name('dashboard.articles.destroy');
});

Route::get('/articles', [ArticleController::class, 'index'])->name('home');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article');
Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
