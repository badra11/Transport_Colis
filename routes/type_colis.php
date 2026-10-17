<?php
use App\Http\Controllers\TypeColisController;
use Illuminate\Support\Facades\Route;


// Route::resource('type_colis', TypeColisController::class)->except(['show']);
Route::get('/type_colis', [TypeColisController::class, 'index'])
	->name('type_colis.index');

 Route::get('/type_colis/create', [TypeColisController::class, 'create'])
    ->name('type_colis.create');

Route::post('/type_colis', [TypeColisController::class, 'store'])
    ->name('type_colis.store');

Route::get('/type_colis/{typeColis}', [TypeColisController::class, 'show'])
    ->name('type_colis.show');

Route::get('/type_colis/{typeColis}/edit', [TypeColisController::class, 'edit'])
    ->name('type_colis.edit');
    
Route::put('/type_colis/{typeColis}', [TypeColisController::class, 'update'])
    ->name('type_colis.update');

Route::delete('/type_colis/{typeColis}', [TypeColisController::class, 'destroy'])
    ->name('type_colis.destroy');