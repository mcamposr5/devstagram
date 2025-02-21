<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        return view('perfil.index');
    }

    public function store(Request $request){

        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required','unique:users,username,'.Auth::user()->id,'min:5','max:15'],
        ]);

        if($request->imagen){
        $imagen = $request->file('imagen');
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000,1000);

        $imagenPath = public_path('perfiles').'/' . $nombreImagen;
        $imagenServidor->save($imagenPath);
        }

        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? '';
        $usuario->save();

        return redirect()->route('posts.index', $usuario->username);
    }
}
