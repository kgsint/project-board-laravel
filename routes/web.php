<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInviteStoreController;
use App\Http\Controllers\ProjectTaskController;


Route::redirect('/', 'projects');

Route::middleware('auth')->group(function() {

    Route::resource('projects', ProjectController::class); // project resource routes

    Route::post('projects/{project}/tasks', [ProjectTaskController::class, 'store'])
                                                                                ->name('tasks.store');

    Route::patch('projects/{project}/tasks/{task}', [ProjectTaskController::class, 'update'])
                                                                                        ->name('tasks.update');

    Route::post('projects/{project}/invite', ProjectInviteStoreController::class)
                                                                            ->name('projects.invite');
});


Auth::routes();

