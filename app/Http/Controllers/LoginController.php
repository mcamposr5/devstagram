<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('/auth.login');
    }

    public function store(Request $request){

          // Validar los campos del formulario
          $validatedData = $request->validate([
              'email' => 'required|email',
              'password' => 'required'
          ]);

          // Si el usuario no se logra autenticar
          if(!Auth::attempt($request->only('email','password'), $request->remember)){
            return back()->with('mensaje', 'Credenciales Incorrectas');
          }
          return redirect()->route('posts.index', ['user' => Auth::user()->username]);
    }
}
