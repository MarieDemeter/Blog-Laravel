<?php

use App\Http\Controllers\admin\ArticleController as AdminArticleController;
use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
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

Route::get('/dashboard', [DashBoardController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::get('/dashboard/articles', [AdminArticleController::class,'index'])->middleware(['auth'])->name('dashboard.articles');
Route::get('/dashboard/create_article', [AdminArticleController::class,'create'])->middleware(['auth'])->name('dashboard.article.create');
Route::post('/dashboard/create_article', [AdminArticleController::class,'store'])->middleware(['auth'])->name('dashboard.article.store');


require __DIR__.'/auth.php';