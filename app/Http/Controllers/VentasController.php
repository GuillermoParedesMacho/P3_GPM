<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carta_coleccion;
use App\Models\Carta;
use App\Models\Coleccion;
use App\Models\Usuario;
use App\Models\Ventas;

class VentasController extends Controller{

	function crear(Request $request){
		//crea una nueva oferta de venta de cartas usando un usuario particular o profesional
		//obtencion y verificacion de datos
		$datos = $request;
		if(!$datos){ return "no datos"; }
		elseif(!$datos->api_token){ return "no datos -api_token-"; }

		//identificacion del usuario
		$usuarios = Usuario::where('api_token','=',$datos->api_token)->get();
		$usuario = $usuarios[0];
		if(!$usuario){ return "usuario no encontrado"; }

		//verificacin de particular o profesional
		if($usuario->Rol == 'Administrador'){return "no autorizado"; }

		//verificacion de datos necesarios
		if(!$datos->Carta_ID){ return "no datos -Carta_ID-"; }
		elseif(!$datos->Stock){ return "no datos -Stock-"; }
		elseif(!$datos->Precio){ return "no datos -Precio-"; }

		//creacion de la nueva venta
		$venta = new Ventas();
		$venta->Carta_ID = $datos->Carta_ID;
		$venta->Usuario_ID = $usuario->id;
		$venta->Stock = $datos->Stock;
		$venta->Precio = $datos->Precio;

		//Actualizar base de datos
		try{
			$venta->save();
		}catch(\Exception $e){
			return $e;
		}
		return "ok";
	}

	function buscar(Request $request){
		//devuelve una lista de cartas que coinciden con el parametro de busqueda, ordenadas por precio de menor a mayor, deben mostrar: nombre, cantidad, precio, vendedor
		//obtencion y verificacion de datos
		$datos = $request;
		if(!$datos){ return "no datos"; }
		elseif(!$datos->Nombre){ return "no datos -Nombre-"; }

		//Busqueda de las ventas correspondientes
		$cartas = Carta::where('Nombre','=',$datos->Nombre)->get();
		$ventas = [];

		foreach($cartas as $carta){
			$temps = Ventas::where('Carta_ID','=',$carta->id)->get();
			foreach($temps as $temp){
				$userTemp = Usuario::find($temp->Usuario_ID);
				$ventas[] = [
					"Nombre_Carta" => $carta->Nombre,
					"Precio" => $temp->Precio,
					"Stock" => $temp->Stock,
					"Usuario_Vendedor" => $userTemp->Nombre
				];
			}
		}
		
		//ordenando oresultados
		usort($ventas, function($a, $b){
			if($a["Precio"] == $b["Precio"]){ return 0; }
			return ($a["Precio"] < $b["Precio"]) ? -1 : 1;
		});

		return response()->json($ventas);
		
	}

}
