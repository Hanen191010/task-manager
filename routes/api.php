<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import necessary controllers
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\TaskDependencyController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Define a group for routes requiring authentication and authorization
Route::middleware('auth:api')->group(function () {

    // Group for routes with rate limiting
    Route::middleware(['throttle:30,1'])->group(function () {

        // Task-related routes
        // Requires 'create_task' permission to create new tasks
        Route::middleware('permission:create_task')->post('/tasks', [TaskController::class, 'store']);
        // No permission needed to get all tasks
        Route::get('/tasks', [TaskController::class, 'index']);
        // No permission needed to get details of a task
        Route::get('/tasks/{task}', [TaskController::class, 'show']);

        // Routes requiring 'manage_task' permission
        // These routes allow updates, deletion, and status changes for tasks
        Route::middleware('permission:manage_task')->group(function () {
            Route::put('/tasks/{task}', [TaskController::class, 'update']);
            Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
            Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus']);
        });

        // Routes requiring 'assign_task' permission
        // These routes allow task reassignment, task assignment, and attachment uploads
        Route::middleware('permission:assign_task')->group(function () {
            Route::put('/tasks/{task}/reassign', [TaskController::class, 'reassign']);
            Route::post('/tasks/{task}/assign', [TaskController::class, 'assign']);
            Route::post('/tasks/{task}/attachments', [AttachmentController::class, 'store']);
        });

        // Routes requiring 'comment_task' permission
        // Allows adding comments to tasks
        Route::middleware('permission:comment_task')->post('/tasks/{task}/comments', [CommentController::class, 'store']);

        // Report-related routes
        // No permission needed to get daily tasks report
        Route::get('/reports/daily-tasks', [ReportController::class, 'dailyTasks']);

        // Task Dependency-related routes
        // No permission needed to create or delete task dependencies
        Route::post('/tasks/{task}/dependencies', [TaskDependencyController::class, 'storeDependencies']);
        Route::delete('/tasks/{task}/dependencies/{dependentTask}', [TaskDependencyController::class, 'destroyDependencies']);

        // Role-related routes
        // No permission needed to get all roles
        Route::get('/roles', [RoleController::class, 'index']);
    });
});

// Routes related to authentication and registration
Route::controller(AuthController::class)->group(function () {
    // No permission needed for login, registration, and logout
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});
