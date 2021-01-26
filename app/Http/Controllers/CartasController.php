<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Carta;
use App\Models\Coleccion;
use App\Models\Carta_coleccion;

class CartasController extends Controller{
    
	function crear(Request $request){
		//crear carta usando una cuenta de usuario administrador
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

		//verificacion de la presencialidad de los datos para crear la carta
		if(!$datos->Nombre){ return "no datos -Nombre-"; }
		elseif(!$datos->Descripcion){ return "no datos -Descripcion-"; }

		//creacion de la carta
		$carta = new Carta();
		$carta->Nombre = $datos->Nombre;
		$carta->Descripcion = $datos->Descripcion;

		//guardado de la carta en la base de datos
		try{
			$carta->save();
		}catch(\Exception $e){
			return $e;
		}
		return "ok";
	}

	function buscar(Request $request){
		//devuelve una lista de cartas que coincidan con el parametro de busqueda, solo admins particulares o profesionales
		//obtencion y verificacion de datos
		$datos = $request;
		if(!$datos){ return "no datos"; }
		elseif(!$datos->api_token){ return "no datos -api_token-"; }

		//identificacion del usuario
		$usuarios = Usuario::where('api_token','=',$datos->api_token)->get();
		if(count($usuarios) == 0){ return "usuario no encontrado"; }
		$usuario = $usuarios[0];

		//verificacin de particular o profesional
		if($usuario->Rol == 'Administrador'){return "no autorizado"; }

		//identificacion de dato de busqueda y filtrado
		if($datos->Nombre){
			$cartas = Carta::where('Nombre','=',$datos->Nombre)->get();
		}
		else{
			$cartas = Carta::get();
		}

		//preparar respuesta
		$resultado = [];
		foreach($cartas as $carta){
    		$resultado[] = [
    			"ID" => $carta->id,
    			"Nombre" => $carta->Nombre,
    			"Descripcion" => $carta->Descripcion
    		];
    	}

		//muestreo de resultados
		return response()->json($resultado);
	}
}