<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    

require __DIR__.'/settings.php';

require __DIR__.'/colis.php';
require __DIR__.'/type_colis.php';
require __DIR__.'/gares.php';
require __DIR__.'/users.php';
require __DIR__.'/permissions.php';
require __DIR__.'/roles.php';
require __DIR__.'/colisPosseder.php';
require __DIR__.'/recupererColis.php';
  


