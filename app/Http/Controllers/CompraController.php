<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CompraController extends Controller
{
    public function historico()
    {
        $user = Auth::user();
        $comprasQuery = Venda::with(['produto', 'vendedor']);

      
        if (!$user->isAdmin) {
            $comprasQuery->where('comprador_id', $user->id);
        }

        $compras = $comprasQuery->latest()->paginate(15);

        return view('compras.historico', compact('compras'));
    }

  
    public function gerarPdf(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $dataInicio = Carbon::parse($request->data_inicio)->startOfDay();
        $dataFim = Carbon::parse($request->data_fim)->endOfDay();
        $user = Auth::user();

        $comprasQuery = Venda::with(['produto', 'comprador', 'vendedor'])
            ->whereBetween('created_at', [$dataInicio, $dataFim]);

        
        if (!$user->isAdmin) {
            $comprasQuery->where('comprador_id', $user->id);
        }

        $compras = $comprasQuery->latest()->get();

        $periodo = [
            'inicio' => $dataInicio->format('d/m/Y'),
            'fim' => $dataFim->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('compras.pdf', compact('compras', 'periodo', 'user'));

        return $pdf->stream('relatorio-compras-' . now()->format('Y-m-d') . '.pdf');
    }
}
