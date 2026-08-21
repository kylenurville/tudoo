<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');
Route::resource('tasks', TaskController::class);
Route::resource('projects', ProjectController::class);
Route::post('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');