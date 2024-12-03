<?php

use App\Livewire\Archived;
use App\Livewire\Archive;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Generate;
use App\Livewire\Records;
use App\Livewire\TimetableView;
use App\Http\Controllers\TimetableController;

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


Route::get('/', Home::class);
Route::get('/generate', Generate::class);
Route::get('/records', Records::class);
Route::get('/archived', Archived::class);
Route::get('/archive/{classId}', Archive::class)->name('archive.show');
Route::get('/search', [Records::class, 'search'])->name('search');
// Route::get('/timetable/{classId}/pdf', [TimetableView::class, 'generatePDF'])->name('timetable.pdf');
Route::get('/timetable/{classId}/pdf', [TimetableController::class, 'generatePDF'])->name('timetable.pdf');
