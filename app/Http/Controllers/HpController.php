<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class HpController extends Controller
{


    public function index()
    {

        $produtos = Produto::all();
        return view('home.home_page', compact('produtos'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $produtos = Produto::query()
            ->where('nome', 'like', "%{$search}%")
            ->orWhere('desc', 'like', "%{$search}%")
            ->orWhere('categoria', 'like', "%{$search}%")
            ->get();

        return view('home.home_page', compact('produtos'));
    }
}
