<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;

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

Route::get('/', [IndexController::class, 'home'])->name('homepage');
Route::get('/category/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/genre/{slug}', [IndexController::class, 'genre'])->name('genre');
Route::get('/country/{slug}', [IndexController::class, 'country'])->name('country');
Route::get('/movie', [IndexController::class, 'movie'])->name('movie');
Route::get('/watching', [IndexController::class, 'watch'])->name('watch');
Route::get('/episode', [IndexController::class, 'episode'])->name('episode');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//route admin
Route::resource('categories', CategoryController::class);
Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');
Route::resource('genres', GenreController::class);
Route::resource('countries', CountryController::class);
Route::resource('episodes', EpisodeController::class);
Route::resource('movies', MovieController::class);
