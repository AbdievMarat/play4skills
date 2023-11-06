<?php

use App\Http\Controllers\Admin\AssignedTaskController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StreamController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'showRegisterForm'])->name('showRegisterForm');
Route::post('register', [LoginController::class, 'register'])->name('register');

Route::get('rating_display', [RatingController::class, 'display'])->name('rating_display');
Route::get('rating/{userId}', [RatingController::class, 'getDetailWithUser'])->name('getDetailWithUser');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resources([
        'users' => UserController::class,
        'messages' => MessageController::class,
        'lessons' => LessonController::class,
        'tasks' => TaskController::class,
    ]);
    Route::resource('questions', QuestionController::class)->only(['index', 'edit', 'update']);
    Route::resource('assigned_tasks', AssignedTaskController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::put('assigned_tasks_accept/{assigned_task}', [AssignedTaskController::class, 'accept'])->name('assignedTasksAccept');
    Route::put('assigned_tasks_revision/{assigned_task}', [AssignedTaskController::class, 'revision'])->name('assignedTasksRevision');
    Route::put('assigned_tasks_under_review/{assigned_task}', [AssignedTaskController::class, 'underReview'])->name('assignedTasksUnderReview');
});

Route::middleware('auth')->group(function () {
    Route::resource('chats', ChatController::class)->only(['index', 'store']);
    Route::get('chats/{userIdFrom}', [ChatController::class, 'getChatWithUser'])->name('getChatWithUser');

    Route::get('stream', [StreamController::class, 'index'])->name('stream');
    Route::post('store_message', [StreamController::class, 'storeMessage'])->name('storeMessage');
    Route::post('store_question', [StreamController::class, 'storeQuestion'])->name('storeQuestion');
    Route::get('client_lessons', [App\Http\Controllers\LessonController::class, 'index'])->name('clientLessons');
    Route::resource('assigned_tasks', App\Http\Controllers\AssignedTaskController::class)->only(['index', 'edit', 'update']);
    Route::resource('users', App\Http\Controllers\UserController::class)->only(['edit', 'update']);
    Route::get('rating', [RatingController::class, 'index'])->name('rating');
});

