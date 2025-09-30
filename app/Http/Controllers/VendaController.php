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
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $dataInicio = \Carbon\Carbon::parse($request->data_inicio)->startOfDay();
        $dataFim = \Carbon\Carbon::parse($request->data_fim)->endOfDay();
        $user = \Illuminate\Support\Facades\Auth::user();

        $vendasQuery = \App\Models\Venda::with(['produto', 'comprador', 'vendedor'])
            ->whereBetween('created_at', [$dataInicio, $dataFim]);

        if (!$user->isAdmin) {
            
            $vendasQuery->where('vendedor_id', $user->id);
        }

        $vendas = $vendasQuery->latest()->get();

      
        $periodo = [
            'inicio' => $dataInicio->format('d/m/Y'),
            'fim' => $dataFim->format('d/m/Y'),
        ];

      
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('vendas.pdf', compact('vendas', 'periodo'));

        return $pdf->stream('relatorio-vendas-' . now()->format('Y-m-d') . '.pdf');
    }
}
