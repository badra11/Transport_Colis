<?php

use App\Http\Controllers\ColisController;
use Illuminate\Support\Facades\Route;

Route::get('/colisPosseder/depot', [ColisController::class, 'depotColisVersGare'])
	->name('colisPosseder.depotColisVersGare');
Route::get('/colisPosseder/listeDepot', [ColisController::class, 'listeColisVersGare'])
	->name('colisPosseder.listeColisVersGare');
	
Route::post('/colisPosseder/envoyerDepot/{id}', [ColisController::class, 'envoyerDepot'])
	->name('colisPosseder.envoyerDepot');
Route::post('/colisPosseder/annulerDepot/{id}', [ColisController::class, 'annulerDepot'])
	->name('colisPosseder.annulerDepot');
Route::post('/colisPosseder/envoyerTout', [ColisController::class, 'envoyerToutVersGare'])
	->name('colisPosseder.envoyerToutVersGare');

Route::get('/colisPosseder/encours', [ColisController::class, 'colisEncoursVersGare'])
	->name('colisPosseder.colisEnCoursVersGare');
Route::get('/colisPosseder/listeEncours', [ColisController::class, 'listeEncoursVersGare'])
	->name('colisPosseder.listeEncoursVersGare');

Route::post('/colisPosseder/annulerEncours/{id}', [ColisController::class, 'annulerEncours'])
	->name('colisPosseder.annulerEncours');
Route::post('/colisPosseder/annulerTout', [ColisController::class, 'annulerToutVersGare'])
	->name('colisPosseder.annulerToutVersGare');

Route::get('/colisPosseder/arriver', [ColisController::class, 'colisArriverVersGare'])
	->name('colisPosseder.colisArriverVersGare');
Route::get('/colisPosseder/listeArriver', [ColisController::class, 'listeArriverVersGare'])
	->name('colisPosseder.listeArriverVersGare');

Route::get('/colisPosseder/colisAnnuler', [ColisController::class, 'colisAnnulerVersGare'])
	->name('colisPosseder.colisAnnulerVersGare');
Route::get('/colisPosseder/listeAnnuler', [ColisController::class, 'listeColisAnnulerVersGare'])
	->name('colisPosseder.listeColisAnnulerVersGare');


Route::post('/colisPosseder/receptionColis/{id}', [ColisController::class, 'receptionColis'])
	->name('colisPosseder.receptionColis');
Route::post('/colisPosseder/receptionTout', [ColisController::class, 'receptionToutVersGare'])
	->name('colisPosseder.receptionToutVersGare');

Route::get('/colisPosseder/colisArriver', [ColisController::class, 'colisArriverGare'])
	->name('colisPosseder.colisArriverGare');
Route::get('/colisPosseder/colisAnnulerDefinitive', [ColisController::class, 'colisAnnulerDefinitive'])
	->name('colisPosseder.colisAnnulerDefinitive');



Route::post('/colisPosseder/renvoyer/{id}', [ColisController::class, 'renvoyerColis'])
    ->name('colisPosseder.renvoyerColis');
Route::post('/colisPosseder/annulerDefinitivement/{id}', [ColisController::class, 'annulerDefinitivement'])
    ->name('colisPosseder.annulerDefinitivement');
