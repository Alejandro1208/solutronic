<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        Mail::send('emails.contacto', $data, function ($message) use ($data) {
            $message->from($data['email'], $data['nombre']);
            $message->to('ejemplo@solutronic.com.ar')->subject('Nuevo mensaje del formulario de Solutronic.com.ar');
        });
    
        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
}
