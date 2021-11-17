<?php

namespace App\Http\Controllers;

use App\Models\Establecimiento;
use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {
        // return $request->all();
        // return $request->file('imagen');
        // leer la imagen 
        $ruta_imagen = $request->file('file')->store('establecimientos','public');

        //reSIZE A LA IMAGEN
        $image = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800,450);
        $image->save();

        //almacenar con modelo
        $imageDB = new Imagen;
        $imageDB->id_establecimiento = $request['uuid'];
        $imageDB->ruta_imagen = $ruta_imagen;
        $imageDB->save();

        //retornar respuesta
        $respuesta = [
            'archivo' => $ruta_imagen
        ];

        return response()->json($respuesta);
    }
    public function destroy(Request $request)
    {
        $uuid = $request->get('uuid');
        $establecimiento = Establecimiento::where('uuid', $uuid)->first();
        $this->authorize('delete', $establecimiento);
        $imagen = $request->get('imagen');

        if(File::exists('storage/'.$imagen)){
            //Elimina imagen del servidor
            File::delete('storage/'.$imagen);
            //Elimina imagen de la BD
            Imagen::where('ruta_imagen',$imagen)->delete();

            $respuesta  = [
                'mensaje' => 'Imagen eliminada',
                'imagen' => $imagen
            ];

        }

        $respuesta  = [
            'mensaje' => 'Imagen eliminada',
            'imagen' => $imagen
        ];

        //Imagen::where('ruta_imagen', '=', $imagen)->delete();
        // $imagenEliminar = Imagen::where('ruta_imagen','=',$imagen)->firstOrFail();
        // Imagen::destroy($imagenEliminar->id);

        return response()->json($request);
    }
}
