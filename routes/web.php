<?php

use App\Http\Controllers\Admin\AssignedTaskController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StreamController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::get('auth_register', [LoginController::class, 'showRegisterForm'])->name('showAuthRegisterForm');
Route::post('auth_register', [LoginController::class, 'register'])->name('authRegister');

Route::get('rating_display', [RatingController::class, 'display'])->name('ratingDisplay');
Route::get('rating_mentor_users/{mentorId}/{archivedAssignedTaskId}', [RatingController::class, 'getMentorUsers'])->name('getRatingUsers');
Route::get('rating_points_detail/{userId}/{archivedAssignedTaskId}', [RatingController::class, 'getPointsDetail'])->name('getPointsDetail');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resources([
        'users' => UserController::class,
        'messages' => MessageController::class,
        'lessons' => LessonController::class,
        'tasks' => TaskController::class,
        'mentors' => MentorController::class,
    ]);
    Route::resource('questions', QuestionController::class)->only(['index', 'edit', 'update']);
    Route::put('update_question_configs', [QuestionController::class, 'updateQuestionConfigs'])->name('updateQuestionConfigs');
    Route::resource('assigned_tasks', AssignedTaskController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::put('assigned_tasks_accept/{assigned_task}', [AssignedTaskController::class, 'accept'])->name('assignedTasksAccept');
    Route::put('assigned_tasks_revision/{assigned_task}', [AssignedTaskController::class, 'revision'])->name('assignedTasksRevision');
    Route::put('assigned_tasks_under_review/{assigned_task}', [AssignedTaskController::class, 'underReview'])->name('assignedTasksUnderReview');
    Route::post('assigned_tasks_archive', [AssignedTaskController::class, 'archive'])->name('assignedTasksArchive');
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

