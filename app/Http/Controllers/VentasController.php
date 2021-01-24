<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\carta_coleccion;
use App\Models\coleccion;
use App\Models\usuario;
use App\Models\ventas;

class VentasController extends Controller{

	function crear(Request $request){
		//crea una nueva oferta de venta de cartas usando un usuario particular o profesional
	}

	function buscar(Request $request){
		//devuelve una lista de cartas que coinciden con el parametro de busqueda, ordenadas por precio de menor a mayor, deben mostrar: nombre, cantidad, precio, vendedor
	}

	/*
	function comprar(Request $request){
		//comprueba que aun queda stock en la oferta, tras lo cual, se realizara la compra, restando en 1 el stock
	}
    */
    
}
