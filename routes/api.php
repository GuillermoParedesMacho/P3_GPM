<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuariosController;

Route::prefix('Usuario')->group(function(){
	Route::post('/registrar',[UsuariosController::class,"registrar"]);
	Route::get('/logIn',[UsuariosController::class,"logIn"]);
	Route::get('/recuperarContrasena',[UsuariosController::class,"recuperarContrasena"]);
});
