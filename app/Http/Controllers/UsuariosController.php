<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuario

class UsuariosController extends Controller{
    
	function registrar(Request $request){
		//registro usuario usando nombre, correo, contraseña y rol
	}

	function logIn(Request $request){
		//logeo de usuario con nombre y contraseña, devolver token
	}

	function recuperarContrasena(Request $request){
		//enviar correo al usuario con una nueva contraseña
		//en caso de muy dificil, con mostrar la contraseña vael (forma chapuza)
	}

}
