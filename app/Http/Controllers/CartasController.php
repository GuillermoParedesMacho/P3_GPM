<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuario;
use App\Models\carta;
use App\Models\coleccion;
use App\Models\carta_coleccion;

class CartasController extends Controller{
    
	function crear(Request $request){
		//crear carta usando una cuenta de usuario administrador
	}

	function buscar(Request $request){
		//devuelve una lista de cartas que coincidan con el parametro de busqueda
	}
}