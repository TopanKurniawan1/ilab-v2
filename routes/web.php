<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PublicScheduleController;



Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');



Route::resource('majors', MajorController::class)->except(['show']);
Route::resource('classes', ClassController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('classrooms', ClassroomController::class);
Route::resource('schedules', ScheduleController::class);
Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
Route::get('/schedules/fetch/{class}', [ScheduleController::class, 'fetch'])->name('schedules.fetch'); // return JSON
Route::post('/schedules/store', [ScheduleController::class, 'store'])->name('schedules.store');       // save weekly
Route::get('/schedules/view/{class}', [ScheduleController::class, 'view'])->name('schedules.view');
Route::get('/jadwal/{class}', [PublicScheduleController::class, 'show'])->name('public.schedules.show');



Route::get('/jadwal', [PublicScheduleController::class, 'index'])->name('public_schedules.index');
