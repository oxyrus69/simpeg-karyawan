<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PerformanceReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamController; // Pastikan ini ada

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grup untuk Manajer DAN Admin
Route::middleware(['auth', 'manager'])->group(function () {
    Route::resource('employees', EmployeeController::class)->except(['index']);
    Route::get('employees/{employee}/reviews/create', [PerformanceReviewController::class, 'create'])->name('reviews.create');
    Route::post('employees/{employee}/reviews', [PerformanceReviewController::class, 'store'])->name('reviews.store');
    
    // DEFINISI ROUTE YANG HILANG DITAMBAHKAN KEMBALI DI SINI
    Route::get('/my-team', [TeamController::class, 'index'])->name('manager.team');
});

// Grup HANYA untuk Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
    Route::get('employees-export', [EmployeeController::class, 'export'])->name('employees.export');
    Route::get('reports/performance', [ReportController::class, 'performance'])->name('reports.performance');
});

require __DIR__.'/auth.php';
