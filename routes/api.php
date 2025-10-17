<?php

use App\Http\Controllers\api\V1\AuthController;
use App\Http\Controllers\api\V1\AuthorController;
use App\Http\Controllers\api\V1\NewsController;
use App\Http\Controllers\api\V1\RubricController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('api.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');

        Route::get('news', [NewsController::class, 'search'])->name('news.search');
        Route::post('news', [NewsController::class, 'store'])->name('news.store');
        Route::get('news/{news}', [NewsController::class, 'show'])->name('news.show');

        Route::get('rubrics/{rubric}', [RubricController::class, 'show'])->name('rubrics.show');
        Route::post('rubrics', [RubricController::class, 'store'])->name('rubrics.store');
        Route::get('rubrics/{rubric}/news', [RubricController::class, 'allNews'])->name('rubrics.news');

        Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
        Route::get('authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
        Route::post('authors', [AuthorController::class, 'store'])->name('authors.store');
    });
});
