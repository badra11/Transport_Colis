<?php

use App\Http\Controllers\GareController;
use Illuminate\Support\Facades\Route;

Route::get('/gares', [GareController::class, 'index'])
	->name('gares.index');

 Route::get('/gares/create', [GareController::class, 'create'])
    ->name('gares.create');

Route::post('/gares', [GareController::class, 'store'])
    ->name('gares.store');

Route::get('/gares/{gare}', [GareController::class, 'show'])
    ->name('gares.show');

Route::get('/gares/{gare}/edit', [GareController::class, 'edit'])
    ->name('gares.edit');
    
Route::put('/gares/{gare}', [GareController::class, 'update'])
    ->name('gares.update');

Route::delete('/gares/{gare}', [GareController::class, 'destroy'])
    ->name('gares.destroy');