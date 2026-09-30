<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NormalNoteController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudyController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth.custom'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    
    Route::get('/notes/{note}/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/notes/{note}/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

    Route::prefix('normal-notes')->group(function () {
        Route::get('/{note}', [NormalNoteController::class, 'show'])->name('normal-notes.show');
        Route::get('/{note}/edit', [NormalNoteController::class, 'edit'])->name('normal-notes.edit');
        Route::put('/{note}', [NormalNoteController::class, 'update'])->name('normal-notes.update');
        Route::put('/{note}/content', [NormalNoteController::class, 'updateContent'])->name('normal-notes.update-content');
        Route::delete('/{note}', [NormalNoteController::class, 'destroy'])->name('normal-notes.destroy');
    });

    Route::prefix('study')->group(function () {
        Route::get('/{note}', [StudyController::class, 'show'])->name('study.show');
        Route::post('/{note}/start', [StudyController::class, 'start'])->name('study.start');
        Route::get('/session/{session}', [StudyController::class, 'session'])->name('study.session');
        Route::post('/session/{session}/review', [StudyController::class, 'review'])->name('study.review');
        Route::get('/session/{session}/complete', [StudyController::class, 'complete'])->name('study.complete');
        Route::get('/session/{session}/break', [StudyController::class, 'break'])->name('study.break');
        Route::get('/review-sessions', [StudyController::class, 'reviewSessions'])->name('study.review-sessions');
Route::post('/session/{session}/start-review', [StudyController::class, 'startReview'])->name('study.start-review');
Route::post('/{note}/start-review', [StudyController::class, 'startReview'])->name('study.start-review');
    });

});
Route::post('/study/session/{session}/save-time', [StudyController::class, 'saveTime'])->name('study.save-time');
Route::get('/study/{session}/resume-from-break', [StudyController::class, 'resumeFromBreak'])->name('study.resume-from-break');
Route::middleware(['auth.custom', 'admin.custom'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});