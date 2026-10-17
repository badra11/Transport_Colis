<?php

use App\Http\Controllers\ColisArriverController;
use Illuminate\Support\Facades\Route;

Route::get('/recupererColis/recuperation', [ColisArriverController::class, 'recuperationColis'])
    ->name('recupererColis.recuperationColis');

Route::post('/recupererColis/verifierCode', [ColisArriverController::class, 'verifierCodeRecuperation'])
    ->name('recupererColis.verifierCode');

Route::post('/recupererColis/rendre/{id}', [ColisArriverController::class, 'rendreColis'])
    ->name('recupererColis.rendreColis');

Route::get('/recupererColis/rendus', [ColisArriverController::class, 'colisRendus'])
    ->name('recupererColis.colisRendus');