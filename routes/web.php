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



Route::resource('/users', \App\Http\Controllers\UtilisateurController::class);
Route::resource('/employees', \App\Http\Controllers\EmployeeController::class);
Route::resource('/contrats', \App\Http\Controllers\ContratController::class);
Route::resource('/conges', \App\Http\Controllers\GestionCongeController::class);
Route::resource('/listes', \App\Http\Controllers\ListesCongeController::class);

Route::get('/getPhoneNumber/{employeeId}', [\App\Http\Controllers\ListesCongeController::class ,'getPhoneNumber']);

Route::get('/categories-conge', [\App\Http\Controllers\CategorieConge::class,'index'])->name('categories-conge.index');
