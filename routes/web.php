<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WorklogController;
use Illuminate\Support\Facades\Route;

// Załącz trasy uwierzytelniania z Breeze
require __DIR__.'/auth.php';

// Strona powitalna
Route::get('/', fn() => view('welcome'))->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/worklogs/my', [WorklogController::class, 'myIndex'])->name('worklogs.myIndex');

    Route::middleware(['admin:moderator,admin'])->group(function () {
        Route::get('/manage/worklogs', [WorklogController::class, 'index'])->name('manage.worklogs.index');
        Route::get('/manage/worklogs/create', [WorklogController::class, 'create'])->name('manage.worklogs.create');
        Route::post('/manage/worklogs', [WorklogController::class, 'store'])->name('manage.worklogs.store');
        Route::get('/manage/worklogs/{worklog}/edit', [WorklogController::class, 'edit'])->name('manage.worklogs.edit');
        Route::put('/manage/worklogs/{worklog}', [WorklogController::class, 'update'])->name('manage.worklogs.update');
        Route::delete('/manage/worklogs/{worklog}', [WorklogController::class, 'destroy'])->name('manage.worklogs.destroy');
    });

    Route::middleware(['admin:admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});