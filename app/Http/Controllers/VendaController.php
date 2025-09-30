<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class VendaController extends Controller
{
    
    public function historico(Request $request)
    {
        $user = Auth::user();

        
        $query = Venda::with(['produto', 'comprador', 'vendedor'])->latest();

        
        if (!$user->isAdmin) {
            $query->where('vendedor_id', $user->id);
        }
        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        $vendas = $query->paginate(15);

        return view('vendas.historico', [
            'vendas' => $vendas,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
        ]);
    }

  
    public function gerarPdf(Request $request)
    {
        $user = Auth::user();

        
        $query = Venda::with(['produto', 'comprador', 'vendedor'])->latest();

        if (!$user->isAdmin) {
            $query->where('vendedor_id', $user->id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        $vendas = $query->get();

        
        $pdf = Pdf::loadView('vendas.pdf', [
            'vendas' => $vendas,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'usuarioLogado' => $user,
        ]);

        return $pdf->stream('relatorio_vendas.pdf');
    }
}
