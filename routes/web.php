<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login',[\App\Http\Controllers\AuthController::class, 'login'])->name('users.login');
Route::post('/login',[\App\Http\Controllers\AuthController::class, 'doLogin']);
Route::post('/logout',[\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');



Route::resource('/employees', \App\Http\Controllers\EmployeeController::class);
Route::resource('/contrats', \App\Http\Controllers\ContratController::class);
Route::resource('/conges', \App\Http\Controllers\GestionCongeController::class);
Route::resource('/listes', \App\Http\Controllers\ListesCongeController::class);
Route::resource('/roles', \App\Http\Controllers\RoleController::class);
Route::resource('/documents', \App\Http\Controllers\DocumentController::class);

Route::get('/listes/conge', [\App\Http\Controllers\ListesCongeController::class,'conge'])->name('listes.conge');


Route::get('/getPhoneNumber/{employeeId}', [\App\Http\Controllers\ListesCongeController::class ,'getPhoneNumber']);

Route::get('/categories-conge', [\App\Http\Controllers\CategorieConge::class,'index'])->name('categories-conge.index');

Route::get('/generate-pdf/{id}', [\App\Http\Controllers\CategorieConge::class,'telechargerPdfDemandeConge'])->name('export.pdf');

Route::get('/valider_demande_conges/{id}', [\App\Http\Controllers\ListesCongeController::class,'valider'])->name('valider_demande_conges');
Route::get('/refuser_demande_conges/{id}', [\App\Http\Controllers\ListesCongeController::class,'refuser'])->name('refuser_demande_conges');

Route::get('mes-demandes-conge', [\App\Http\Controllers\ListesCongeController::class, 'mesDemandes'])->name('mes_demandes_conge');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/documents/attestation',[\App\Http\Controllers\DocumentController::class, 'attestation'])->name('documents.attestation');
Route::get('/documents/contrat',[\App\Http\Controllers\DocumentController::class, 'contrat'])->name('documents.contrat');
Route::get('/documents/leave',[\App\Http\Controllers\DocumentController::class, 'conge'])->name('documents.leave_request');
