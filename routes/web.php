<?php

use App\Livewire\Archived;
use App\Livewire\Archive;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Generate;
use Illuminate\Support\Facades\Auth; // Add this line to import the Auth facade
use App\Livewire\Records;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public Routes (No authentication required)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');


// Routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/', Home::class);
    Route::get('/generate', Generate::class);
    Route::get('/records', Records::class);
    Route::get('/archived', Archived::class);
    Route::get('/archive/{classId}', Archive::class)->name('archive.show');
    Route::get('/search', [Records::class, 'search'])->name('search');

    // Routes that require authentication
    Route::get('/timetable/{classId}/pdf', [TimetableController::class, 'generatePDF'])->name('timetable.pdf');

    // Fallback route to redirect any undefined route to '/'
Route::fallback(function () {
    return redirect('/');
});
});
