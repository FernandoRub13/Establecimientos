<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Establecimiento;
use App\Models\Imagen;
use Illuminate\Http\Request;

class APIController extends Controller
{
    // metodo para obtener todos los establecimientos
    public function index()
    {
        $establecimientos = Establecimiento::all();
        return response()->json($establecimientos->load('categoria'));
    }
    // metodo para obtener todas las categorias
    public function categorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
    // muestra los establemientos de la categoria en específico
    public function categoria(Categoria $categoria)
    {
        $establecimientos = $categoria->establecimientos; 
        return response()->json($establecimientos->load('categoria')->take(3) );
    }
    public function categoriaTodos(Categoria $categoria)
    {
        $establecimientos = $categoria->establecimientos; 
        return response()->json($establecimientos->load('categoria') );
    }

    // muestra un establecimiento en específico
    public function show(Establecimiento $establecimiento)
    {
        $imagenes = Imagen::where('id_establecimiento',  $establecimiento->uuid)->get();
        $establecimiento->imagenes = $imagenes;
        
        return response()->json($establecimiento);
    }
}
