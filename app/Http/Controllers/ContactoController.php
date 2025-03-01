<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',
            'mensaje' => 'required',
        ]);
    
        $data = $request->all();

        Mail::send('emails', $data, function ($message) use ($data) {
            $message->from('deposito@solutronic.com.ar', $data['nombre']); // Envía desde la dirección correcta
            $message->to('deposito@solutronic.com.ar')->subject('Nuevo mensaje del formulario de Solutronic.com.ar');
        });
        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
}
