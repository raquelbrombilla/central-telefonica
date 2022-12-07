<?php

use App\Http\Controllers\RamalController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/empresas', [EmpresaController::class, 'index']);
Route::get('/ajaxEmpresas', [EmpresaController::class, 'ajaxEmpresas'])->name('empresas.ajaxEmpresas');
Route::get('/show/{id}', [EmpresaController::class, 'show'])->name('empresas.show');
Route::post('/store', [EmpresaController::class, 'store'])->name('empresas.store');
Route::post('/update/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
Route::delete('/delete/{id}', [EmpresaController::class, 'delete'])->name('empresas.delete');

Route::get('/ramal/{id_empresa}', [RamalController::class, 'index'])->name('ramal.index');
Route::get('/ajaxRamal/{id_empresa}', [RamalController::class, 'ajaxRamal'])->name('ramal.ajaxRamal');
Route::get('/showRamal/{id}', [RamalController::class, 'show'])->name('ramal.show');
Route::post('/updateRamal/{id}', [RamalController::class, 'update'])->name('ramal.update');


