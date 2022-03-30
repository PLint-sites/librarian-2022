<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// Logged in
Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/', function () {
        return redirect(route('books'));
    });
    // On boarding
    Route::get('add-your-first-book', [App\Http\Controllers\BoardingController::class, 'addYourFirstBook']);
    Route::post('book-and-writer', [App\Http\Controllers\BoardingController::class, 'storeBookAndWriter']);
    
    // Books
    Route::get('books', [App\Http\Controllers\BooksController::class, 'index'])->name('books');
    Route::get('books/draw/{page}/{search?}', [App\Http\Controllers\BooksController::class, 'draw'])->name('more-books');

    Route::post('book', [App\Http\Controllers\BooksController::class, 'store']);
    Route::patch('book/{book}', [App\Http\Controllers\BooksController::class, 'update']);
    Route::delete('book/{book}', [App\Http\Controllers\BooksController::class, 'delete']);

    // Writers
    Route::get('writers', [App\Http\Controllers\WritersController::class, 'index'])->name('writers');
    Route::post('writer', [App\Http\Controllers\WritersController::class, 'store']);
    Route::patch('writer/{writer}', [App\Http\Controllers\WritersController::class, 'update']);
    Route::delete('writer/{writer}', [App\Http\Controllers\WritersController::class, 'delete']);
});