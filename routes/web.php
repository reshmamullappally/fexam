<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/course/{slug}', [CourseController::class, 'index'])->name('course');
Route::get('/exam/{slug}', [ExamController::class, 'index'])->name('exam');

