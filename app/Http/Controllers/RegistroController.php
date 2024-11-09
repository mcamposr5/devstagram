<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    //
    public function index()
    {
        return view('auth.registro');
    }

    public function store(Request $request)
    {
        //modificar el request antes de llegar a crear el usuario
        $request->request->add(['username' => Str::slug($request->username)]);

        //dd($request);
        // Validar los campos del formulario
        $validatedData = $request->validate([
            'name' => 'required|min:5|max:30',
            'username' => 'required|unique:users|min:5|max:15',
            'email' => 'required|unique:users|email|max:20',
            'password' => 'required|confirmed|min:6|max:16'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email'=> $request->email,
            'password'=>$request->password
        ]);

        //Autenticar el usuario
        /*auth()->Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);*/

        //Otra manera de autenticar
        Auth::attempt($request->only('email', 'password'));

        return redirect()->route('posts.index', ['user' => Auth::user()->username]);
    }
}
