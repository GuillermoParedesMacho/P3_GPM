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
		if(count($usuarios) == 0){ return "usuario no encontrado"; }
		$usuario = $usuarios[0];

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

		$ventas = [];
		if($datos->Nombre){//Busqueda de las ventas correspondientes por nombre
			$cartas = Carta::where('Nombre','=',$datos->Nombre)->get();

			//filtro de ventas a traves del array de cartas
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
		}
		else{//Busqueda de las ventas correspondientes sin nombre
			$temps = Ventas::orderBy('Precio','asc')->get();

			//filtrado de datos
			foreach($temps as $temp){
				$userTemp = Usuario::find($temp->Usuario_ID);
				$cartaTemp = Carta::find($temp->Carta_ID);
				$ventas[] = [
					"Nombre_Carta" => $cartaTemp->Nombre,
					"Precio" => $temp->Precio,
					"Stock" => $temp->Stock,
					"Usuario_Vendedor" => $userTemp->Nombre
				];
			}
		}
		

		return response()->json($ventas);
		
	}

}
