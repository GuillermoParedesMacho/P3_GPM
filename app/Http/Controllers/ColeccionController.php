<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Coleccion;

class ColeccionController extends Controller{

    function crear(Request $request){
		//crear coleccion usando una cuenta de usuario administrador
		//obtencion y verificacion de datos
		$datos = $request;
		if(!$datos){ return "no datos"; }
		elseif(!$datos->api_token){ return "no datos -api_token-"; }

		//identificacion del usuario
		$usuarios = Usuario::where('api_token','=',$datos->api_token)->get();
		if(count($usuarios) == 0){ return "usuario no encontrado"; }
		$usuario = $usuarios[0];

		//verificacin de admin
		if($usuario->Rol != 'Administrador'){return "no autorizado"; }

		//Identificacion de datos necesarios
		if(!$datos->Nombre){ return "no datos -Nombre-"; }
		elseif(!$datos->Simbolo){ return "no datos -Simbolo-"; }
		elseif(!$datos->Fecha_Edicion){ return "no datos -Fecha_Edicion-"; }

		//creacion nueva coleccion
		$coleccion = new Coleccion();
		$coleccion->Nombre = $datos->Nombre;
		$coleccion->Simbolo = $datos->Simbolo;
		$coleccion->Fecha_Edicion = $datos->Fecha_Edicion;

		//Actualizar base de datos
		try{
			$coleccion->save();
		}catch(\Exception $e){
			return $e;
		}
		return "ok";
	}
}
