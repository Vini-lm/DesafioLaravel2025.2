<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;


class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('home/home_page', compact('produtos'));
    }

    public function show($id)
    {
       $produto = Produto::with('vendedor')->findOrFail($id);
        return view('produtos.pvi_product', compact('produto'));
    }

    public function comprar($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.compra', compact('produto'));
    }


    public function finalizarCompra(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);
        $quantidade = $request->input('quantidade');

        if ($quantidade > $produto->quantidade) {
            return back()->with('error', 'Quantidade solicitada maior que o estoque disponível.');
        }

        
        $produto->quantidade -= $quantidade;
        $produto->save();

        return redirect()->route('produtos.index')->with('success', 'Compra realizada com sucesso!');
    }
}
