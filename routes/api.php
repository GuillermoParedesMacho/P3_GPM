<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CartasController;
use App\Http\Controllers\ColeccionController;
use App\Http\Controllers\CartasColeccionsController;
use App\Http\Controllers\VentasController;

Route::prefix('Usuario')->group(function(){
	Route::post('/registrar',[UsuariosController::class,"registrar"]);
	Route::get('/logIn',[UsuariosController::class,"logIn"]);
	Route::get('/recuperarContrasena',[UsuariosController::class,"recuperarContrasena"]);
});

Route::prefix('Carta')->group(function(){
	Route::post('/crear',[CartasController::class,"crear"]);
	Route::get('/buscar',[CartasController::class,"buscar"]);
});

Route::prefix('Coleccion')->group(function(){
	Route::post('/crear',[ColeccionController::class,"crear"]);
});

Route::prefix('CartaColeccion')->group(function(){
	Route::post('/crear',[CartasColeccionsController::class,"crear"]);
});

Route::prefix('Ventas')->group(function(){
	Route::post('/crear',[VentasController::class,"crear"]);
	Route::get('/buscar',[VentasController::class,"buscar"]);
});