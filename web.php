<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::get('/display', [StudentController::class, 'display'])->name('students.display');
Route::get('/createForm', [StudentController::class, 'createForm'])->name('students.createForm');
Route::post('/create', [StudentController::class, 'store'])->name('students.store');
Route::post('/addSubject', [StudentController::class, 'addSubject'])->name('students.addSubject');
Route::get('/removeSubject/{index}', [StudentController::class, 'removeSubject'])->name('students.removeSubject');
Route::delete('/remove/{id}', [StudentController::class, 'remove'])->name('students.remove');


// Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('students.edit');
// Route::put('/update/{id}', [StudentController::class, 'update'])->name('students.update');



