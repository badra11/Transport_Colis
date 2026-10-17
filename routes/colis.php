<?php

use App\Http\Controllers\ColisController;
use Illuminate\Support\Facades\Route;

Route::get('/colis', [ColisController::class, 'index'])
	->name('colis.index');

Route::get('/colis/create', [ColisController::class, 'create'])
    ->name('colis.create');

Route::post('/colis', [ColisController::class, 'store'])
    ->name('colis.store');

Route::get('/colis/{colis}', [ColisController::class, 'show'])
    ->name('colis.show');

Route::get('/colis/{colis}/edit', [ColisController::class, 'edit'])
    ->name('colis.edit');

Route::put('/colis/{colis}', [ColisController::class, 'update'])
    ->name('colis.update');

Route::delete('/colis/{colis}', [ColisController::class, 'destroy'])
    ->name('colis.destroy');

