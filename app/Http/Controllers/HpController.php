<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class HpController extends Controller
{


    public function index(Request $request)
    {
       
        $categorias = Produto::select('categoria')->distinct()->orderBy('categoria')->pluck('categoria');

      
        $userId = Auth::id();
        $query = Produto::where('vendedor_id', '!=', $userId);

      
        $categoriaSelecionada = $request->input('categoria');
        if ($categoriaSelecionada) {
            $query->where('categoria', $categoriaSelecionada);
        }

      
        $search = $request->input('search');
        if ($search) {
        
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('desc', 'like', "%{$search}%")
                    ->orWhere('categoria', 'like', "%{$search}%");
            });
        }

       
        $produtos = $query->latest()->get();

      
        return view('home.home_page', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'categoriaSelecionada' => $categoriaSelecionada,
            'search' => $search,
        ]);
    }
}
