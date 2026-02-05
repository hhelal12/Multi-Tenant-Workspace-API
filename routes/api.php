<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SummaryController;


// USERS
Route::get('/users', [UsersController::class, 'returnUsers']);
Route::post('/users', [UsersController::class, 'addUser']);


// WORKSPACES
Route::prefix('workspaces')->group(function () {
    Route::post('/', [WorkspaceController::class, 'createWorkspace']);
    Route::get('/', [WorkspaceController::class, 'getAllWorkspace']);
    Route::post('{id}/users', [WorkspaceController::class, 'addUserToWorkspace']);
});


// TASKS
Route::post('/tasks', [TaskController::class, 'addTask']);
Route::get('/tasks', [TaskController::class, 'getTask']);
Route::patch('/tasks/{id}', [TaskController::class, 'editTask']);


// SUMMARY
Route::get('/summary', [SummaryController::class, 'getSummary']);
