<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SponsorshipController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::resource('messages', MessageController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //visualizzazione messaggi singolo appartamento
    Route::get('[apartment/{apartment}/messages', [MessageController::class, 'showByApartment'])->name('messages.single');

    //sponsorship
    // Route::resource('sponsorships', SponsorshipController::class);

    // Route::resource('sponsorships', SponsorshipController::class)->parameters(['sponsorships' => 'sponsorship:id']);
    //Route::resource('sponsorships', SponsorshipController::class)->parameters(['sponsorships' => 'apartment:slug']);

    Route::get('sponsorships/{apartment}', [SponsorshipController::class, 'show'])->name('sponsorships.show');
    Route::post('sponsorships/{apartment}', [SponsorshipController::class, 'store'])->name('sponsorships.store');
});

require __DIR__ . '/auth.php';
