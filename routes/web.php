<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

// Root → login
Route::get('/', fn () => redirect()->route('login'));

// ─── Auth ─────────────────────────────────────────────────────
Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin ────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard',        [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',            [AdminController::class, 'users'])->name('users');
    Route::get('/users/create',     [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users/store',     [AdminController::class, 'storeUser'])->name('users.store');
    Route::delete('/users/{user}',  [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/settings',         [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings',        [AdminController::class, 'saveSettings'])->name('settings.save');
});

// ─── Teacher ──────────────────────────────────────────────────
Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->name('teacher.')->group(function () {
    Route::get('/dashboard',                              [TeacherController::class, 'dashboard'])->name('dashboard');

    // Courses
    Route::get('/courses/create',                         [TeacherController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses/store',                         [TeacherController::class, 'storeCourse'])->name('courses.store');

    // Assignments
    Route::get('/courses/{course}/assignments',           [TeacherController::class, 'courseAssignments'])->name('assignments');
    Route::get('/courses/{course}/assignments/create',    [TeacherController::class, 'createAssignment'])->name('assignments.create');
    Route::post('/courses/{course}/assignments/store',    [TeacherController::class, 'storeAssignment'])->name('assignments.store');
    Route::get('/assignments/{assignment}/submissions',   [TeacherController::class, 'submissions'])->name('submissions');
    Route::post('/submissions/{submission}/marks',        [TeacherController::class, 'assignMarks'])->name('marks');

    // Download student submission
    Route::get('/submissions/{submission}/download',      [TeacherController::class, 'downloadSubmission'])->name('submission.download');

    // Lectures
    Route::get('/courses/{course}/lectures',              [TeacherController::class, 'courseLectures'])->name('lectures');
    Route::get('/courses/{course}/lectures/create',       [TeacherController::class, 'createLecture'])->name('lectures.create');
    Route::post('/courses/{course}/lectures/store',       [TeacherController::class, 'storeLecture'])->name('lectures.store');
    Route::delete('/lectures/{lecture}',                  [TeacherController::class, 'deleteLecture'])->name('lectures.delete');
});

// ─── Student ──────────────────────────────────────────────────
Route::prefix('student')->middleware(['auth', 'role:student'])->name('student.')->group(function () {
    Route::get('/dashboard',                              [StudentController::class, 'dashboard'])->name('dashboard');
    Route::post('/enroll/{course}',                       [StudentController::class, 'enroll'])->name('enroll');
    Route::get('/courses/{course}',                       [StudentController::class, 'courseDetail'])->name('course.detail');
    Route::get('/assignments/{assignment}/submit',        [StudentController::class, 'submitForm'])->name('submit.form');
    Route::post('/assignments/{assignment}/submit',       [StudentController::class, 'submitAssignment'])->name('submit');
    Route::get('/marks',                                  [StudentController::class, 'marks'])->name('marks');

    // Download lecture file
    Route::get('/lectures/{lecture}/download',            [StudentController::class, 'downloadLecture'])->name('lecture.download');

    // Download assignment notes
    Route::get('/notes/{filename}',                       [StudentController::class, 'downloadNote'])->name('notes.download');

    // AI
    Route::get('/ai',                                     [StudentController::class, 'aiPage'])->name('ai');
    Route::post('/ai/ask',                                [StudentController::class, 'askAI'])->name('ai.ask');
});
