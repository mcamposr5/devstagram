<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function __invoke()
    {

        //Obtener los usuarios que sigo para mostrar en la página principal
        $ids = Auth::user()->following->pluck('id')->toArray();

        dd(Auth::user()->following->pluck('id')->toArray());
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(5);
        dd(Post::whereIn('user_id', $ids)->latest()->paginate(5));
        dd($posts);

        return view('home', [
            'posts' => $posts
        ]);
    }
}
