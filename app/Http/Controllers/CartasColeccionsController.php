<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carta_coleccion;
use App\Models\Coleccion;
use App\Models\Usuario;

class CartasColeccionsController extends Controller{
	
    function crear(Request $request){
		//crear una relacion carta-coleccion usando un usuario administrador
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

		//identificacion de datos necesarios
		if(!$datos->Carta_ID){ return "no datos -Carta_ID-"; }
		elseif(!$datos->Coleccion_ID){ return "no datos -Coleccion_ID-"; }

		//creacion del nuevo valor
		$relacion = new Carta_coleccion();
		$relacion->Carta_ID = $datos->Carta_ID;
		$relacion->Coleccion_ID = $datos->Coleccion_ID;

		//Actualizar base de datos
		try{
			$relacion->save();
		}catch(\Exception $e){
			return $e;
		}
		return "ok";
	}
}
