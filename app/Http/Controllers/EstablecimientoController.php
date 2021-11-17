<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Establecimiento;
use App\Models\Imagen;
use Intervention\Image\Facades\Image;

class EstablecimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('establecimientos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('desde store');
        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'exists:App\Models\Categoria,id',
            'imagen_principal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required',
            'descripcion' => 'required|min:40',
            'apertura' => 'required|date_format:H:i',
            'cierre' => 'required|date_format:H:i|after:apertura', 
            'uuid' => 'required|unique:App\Models\Establecimiento,uuid',
        ]);
        $ruta_imagen = $request->file('imagen_principal')->store('principales', 'public');
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 600);
        $img->save();

        // Otra forma de crear un establecimiento
        // $establecimiento = new Establecimiento($data);
        // $establecimiento->imagen_principal = $ruta_imagen;
        // $establecimiento->user_id = auth()->user()->id;
        // $establecimiento->save();         

        auth()->user()->establecimiento()->create([
            'nombre' => $data['nombre'],
            'categoria_id' => $data['categoria_id'],
            'imagen_principal' => $ruta_imagen,
            'direccion' => $data['direccion'],
            'colonia' => $data['colonia'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'telefono' => $data['telefono'],
            'descripcion' => $data['descripcion'],
            'apertura' => $data['apertura'],
            'cierre' => $data['cierre'],
            'uuid' => $data['uuid'],
        ]);

        return back()->with('estado', 'Establecimiento creado con éxito');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Establecimiento $establecimiento)
    {
        $categorias = Categoria::all();
        $establecimiento = auth()->user()->establecimiento;
        $establecimiento->apertura = date('H:i', strtotime($establecimiento->apertura));
        $establecimiento->cierre = date('H:i', strtotime($establecimiento->cierre));
        // obtiene las imagenes del establecimiento
        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();
        return view('establecimientos.edit', compact('categorias', 'establecimiento', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establecimiento $establecimiento)
    {
        //ejecutar policy
        $this->authorize('update', $establecimiento);
        // validar datos
        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'exists:App\Models\Categoria,id',
            'imagen_principal' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required',
            'descripcion' => 'required|min:40',
            'apertura' => 'required|date_format:H:i',
            'cierre' => 'required|date_format:H:i|after:apertura', 
            'uuid' => 'required|unique:App\Models\Establecimiento,uuid,'.$establecimiento->uuid ,
        ]);

        $establecimiento->nombre = $data['nombre'];
        $establecimiento->categoria_id = $data['categoria_id'];
        $establecimiento->direccion = $data['direccion'];
        $establecimiento->colonia = $data['colonia'];
        $establecimiento->lat = $data['lat'];
        $establecimiento->lng = $data['lng'];
        $establecimiento->telefono = $data['telefono'];
        $establecimiento->descripcion = $data['descripcion'];
        $establecimiento->apertura = $data['apertura'];
        $establecimiento->cierre = $data['cierre'];
        $establecimiento->uuid = $data['uuid'];

        //si el usuario sube una imagen principal la  actualizamos

        if (request('imagen_principal')) {
            //guardar la imagen
            $ruta_imagen = $request['imagen_principal']->store('principales', 'public');
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 600);
            $img->save();
            $establecimiento->imagen_principal = $ruta_imagen;
            //eliminar la imagen anterior
        }
        // guardar el registro
        $establecimiento->save();


        return back()->with('estado', 'Establecimiento actualizado con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
