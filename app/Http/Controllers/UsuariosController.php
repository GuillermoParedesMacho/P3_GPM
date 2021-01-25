<?php

namespace App\Http\Controllers;

//TODO cambiar los nombres de los modelos para que empiecen por mayuscula
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class UsuariosController extends Controller{
    
	function registrar(Request $request){
		//registro usuario usando nombre, correo, contraseña y rol
		//obtencion y verificacion de datos
		$datos = $request;
		if(!$datos){ return "no datos"; }
		elseif(!$datos->Nombre){ return "no datos -Nombre-"; }
		elseif(!$datos->Correo){ return "no datos -Correo-"; }
		elseif(!$datos->Contrasena){ return "no datos -Contrasena-"; }
		elseif(!$datos->Rol){ return "no datos -Rol-"; }

		//creacion del nuevo usuario
		$usuario = new Usuario();
		$usuario->Nombre = $datos->Nombre;
		$usuario->Correo = $datos->Correo;
		$usuario->Contrasena = Crypt::encryptString($datos->Contrasena);
		$usuario->Rol = $datos->Rol;

		//enviar daros a la base de datos
		try{
			$usuario->save();
		}catch(\Exception $e){
			return $e;
		}
		return "ok";

	}

	function logIn(Request $request){
		//logeo de usuario con nombre y contraseña, devolver token
		//obtencion y verificacion de datos
		$datos = $request;
		if(!$datos){ return "no datos"; }
		elseif(!$datos->Nombre){ return "no datos -Nombre-"; }
		elseif(!$datos->Contrasena){ return "no datos -Contrasena-"; }

		//busqueda del usuario
		$usuarios = Usuario::where('Nombre','=',$datos->Nombre)->get();
		$usuario = $usuarios[0];
		if(!$usuario){ return "usuario no encontrado"; }

		//verificacion de contraseña
		$contrasena = Crypt::decryptString($usuario->Contrasena);
		if($contrasena != $datos->Contrasena){ return "contraseña incorrecta"; }

		//generacion de token
		//nota: documentacion -> https://laravel.com/docs/5.8/api-authentication#generating-tokens
		$token = Str::random(60);

		//verificacion de token generado correctamente y guardado de este
		$usuario->api_token = $token;

		//actualizar base de datos
		try{
			$usuario->save();
		}catch(\Exception $e){
			return $e;
		}
		return response()->json($token);
	}

	function recuperarContrasena(Request $request){
		//enviar correo al usuario con una nueva contraseña
		//en caso de muy dificil, con mostrar la contraseña vael (forma chapuza)
		//obtencion y verificacion de datos
		$datos = $request;
		if(!$datos){ return "no datos"; }
		elseif(!$datos->Correo){ return "no datos -Correo-"; }

		//busqueda del usuario
		$usuarios = Usuario::where('Correo','=',$datos->Correo)->get();
		$usuario = $usuarios[0];
		if(!$usuario){ return "usuario no encontrado"; }

		//generacion de la nueva contraseña
		$contrasenaINT = random_int(1000, 9999);
		$contrasena = (string)$contrasenaINT;

		//actualizado contrasena
		$usuario->Contrasena = Crypt::encryptString($contrasena);

		//guardar en bae de datos
		try{
			$usuario->save();
		}catch(\Exception $e){
			return $e;
		}
		return response()->json($contrasena);
	}

}