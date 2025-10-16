<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RubricController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::resource('news', NewsController::class);
Route::post('rubrics', [RubricController::class, 'store'])->name('rubrics.store');
Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
Route::post('authors', [AuthorController::class, 'store'])->name('authors.store');