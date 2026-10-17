<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/permissions', [PermissionController::class, 'index'])
	->name('permissions.index');

Route::get('/permissions/create', [PermissionController::class, 'create'])
    ->name('permissions.create');

Route::post('/permissions', [PermissionController::class, 'store'])
    ->name('permissions.store');

Route::get('/permissions/{permission}', [PermissionController::class, 'show'])
    ->name('permissions.show');

Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
    ->name('permissions.edit');

Route::put('/permissions/{permission}', [PermissionController::class, 'update'])
    ->name('permissions.update');

Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
    ->name('permissions.destroy');