<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\front\ArticleController as FrontArticleController;
use UniSharp\LaravelFilemanager\Lfm;

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

Route::name('home')->get('/', [FrontArticleController::class, 'index'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web','auth']], function (){
    Lfm::routes();
});

Route::prefix('articles')->group(function () {
    Route::name('articles.search')->get('', [FrontArticleController::class, 'search']);
    Route::name('articles.display')->get('{slug}', [FrontArticleController::class, 'show']);
});

Route::name('category')->get('category/{category:slug}', [FrontArticleController::class, 'category']);

Route::name('author')->get('author/{user}', [FrontArticleController::class, 'user']);

Route::name('tag')->get('tag/{tag:slug}', [FrontArticleController::class, 'tag']);

require __DIR__.'/auth.php';
