<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\FavoriteController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth' )->group(function () {

	Route::middleware('admin' )->group(function () {
		Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
		Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
		Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

		//store update
		Route::delete('/buku/{buku}/gallery/{gallery}', [BukuController::class, 'hapusGallery'])->name('buku.hapusGallery');
		Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

	});
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::post('/buku/rating_update/{id}', [BukuController::class, 'rating_update'])->name('buku.rating_update');
	Route::get('/buku/rating/{id}', [BukuController::class, 'rating'])->name('buku.rating');
	Route::get('/buku',[BukuController::class,'index']);
	Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
	Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
	Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
	Route::get('/buku/list_buku',[BukuController::class,'list_buku']);
	Route::get('/buku/detail_buku', [BukuController::class,'detail_buku'])->name('buku.detail_buku');
	Route::get('/buku/detail_buku/{title}', [BukuController::class, 'galbuku'])->name('galeri.buku');

	Route::post('/favorites/{buku}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/buku/myfavourite', [FavoriteController::class, 'index'])->name('buku.myfavourite');
});

require __DIR__.'/auth.php';
