<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Asegura que solo usuarios autenticados puedan acceder a los métodos de este controlador
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Asegúrate de que solo el dueño de la página pueda acceder
        if (Auth::user()->email != 'alejandroramonsabater@hotmail.com') {
            abort(403);
        }

        // Almacena la URL actual en la sesión
        $request->session()->put('admin_url', $request->url());

        if ($request->has('filter')) {
            $productos = Producto::where('filter', $request->filter)->paginate(9);
        } else {
            $productos = Producto::paginate(9);
        }

        return view('admin', compact('productos'));
    }
}