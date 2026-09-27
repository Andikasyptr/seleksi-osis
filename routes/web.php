<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

// Halaman Welcome / Landing Page Utama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute Autentikasi (Login & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Kelola Siswa
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::put('/students/{user}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{user}', [AdminController::class, 'destroyStudent'])->name('students.destroy');
    
    // Kelola Jadwal Ujian (Lengkap: Index, Store, Update, Destroy)
    Route::get('/exams', [AdminController::class, 'exams'])->name('exams');
    Route::post('/exams', [AdminController::class, 'storeExam'])->name('exams.store');
    Route::put('/exams/{exam}', [AdminController::class, 'updateExam'])->name('exams.update');
    Route::delete('/exams/{exam}', [AdminController::class, 'destroyExam'])->name('exams.destroy');
    
    // Builder Soal & Import Excel
    Route::get('/exams/template-download', [AdminController::class, 'downloadTemplate'])->name('builder.template');
    Route::get('/exams/{exam}/builder', [AdminController::class, 'builder'])->name('builder');
    Route::post('/exams/{exam}/builder', [AdminController::class, 'storeQuestion'])->name('builder.store');
    Route::post('/exams/{exam}/import', [AdminController::class, 'importExcel'])->name('builder.import');
    
    // Rekap & Kelulusan
    Route::get('/results', [AdminController::class, 'results'])->name('results');
    Route::post('/students/{user}/status', [AdminController::class, 'updateStatus'])->name('students.status');

    // Rekap & Kelulusan (Tambah rute bulk update)
    Route::get('/results', [AdminController::class, 'results'])->name('results');
    Route::post('/students/{user}/status', [AdminController::class, 'updateStatus'])->name('students.status');
    Route::post('/students/bulk-status', [AdminController::class, 'bulkUpdateStatus'])->name('students.bulk-status');
});

// Rute khusus Siswa
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/exams', [StudentController::class, 'examsIndex'])->name('exams');
    Route::get('/exam/{exam}', [StudentController::class, 'examRoom'])->name('exam.room');
    Route::post('/exam/{exam}/submit', [StudentController::class, 'submitExam'])->name('exam.submit');
});