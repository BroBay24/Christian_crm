<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
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
});

require __DIR__.'/auth.php';
