<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Entidades\Sistema\Postulacion;
require app_path() . '/start/constants.php';

class ControladorWebContacto extends Controller
{
    public function index()
    {
            return view('web.contacto');
    }

    public function enviar(Request $request)
    {
        $postulacion = new Postulacion();
        $postulacion->cargarDesdeRequest($request);

        if ($request->hasFile('archivo') && $request->file('archivo')->isValid()) {
            $extension = $request->file('archivo')->getClientOriginalExtension();
            $nombre = date("Ymdhmsi") . "." . $extension;
            $request->file('archivo')->move(env('APP_PATH') . "/public/files/", $nombre);
            $postulacion->curriculum = $nombre;
        }

        try{
            $postulacion->insertar();
            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["MSG"] = "Postulación enviada con éxito";

        }catch(Exception $e){
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Error al enviar postulación";

        }
        return view('web.contacto', compact('msg'));



        
    }
}
