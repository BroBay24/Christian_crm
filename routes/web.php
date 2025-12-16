<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Lead - Resource Route
    Route::resource('leads', LeadController::class);
    
    // Route tambahan untuk approve/reject (khusus manager)
    Route::post('leads/{lead}/approve', [LeadController::class, 'approve'])->name('leads.approve');
    Route::post('leads/{lead}/reject', [LeadController::class, 'reject'])->name('leads.reject');

    // CRUD Project - Resource Route (khusus manager)
    Route::resource('projects', ProjectController::class);
    
    // Route tambahan untuk approve/reject project (khusus manager)
    Route::post('projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
    Route::post('projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');

    // CRUD Customer - Resource Route (khusus manager)
    Route::resource('customers', CustomerController::class);
    
    // Route untuk konversi project ke customer (khusus manager)
    Route::post('customers/convert/{project}', [CustomerController::class, 'convertFromProject'])->name('customers.convert');
});

require __DIR__.'/auth.php';
