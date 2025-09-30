<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

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

        $chart = null;
        if ($user->isAdmin) {
            $chart_options = [
                'chart_title' => 'Vendas por Mês (Últimos 12 Meses)',
                'report_type' => 'group_by_date',
                'model' => Venda::class,
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'chart_type' => 'line',
                'chart_color' => '34, 139, 230',
                'last_days' => 365,
            ];
            $chart = new LaravelChart($chart_options);
        }

        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;

        return view('vendas.historico', compact('vendas', 'chart', 'data_inicio', 'data_fim'));
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

        $vendasQuery = Venda::with(['produto', 'comprador', 'vendedor'])
            ->whereBetween('created_at', [$dataInicio, $dataFim]);

        if (!$user->isAdmin) {
            $vendasQuery->where('vendedor_id', $user->id);
        }

        $vendas = $vendasQuery->latest()->get();

        $periodo = [
            'inicio' => $dataInicio->format('d/m/Y'),
            'fim' => $dataFim->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('vendas.pdf', compact('vendas', 'periodo'));

        return $pdf->stream('relatorio-vendas-' . now()->format('Y-m-d') . '.pdf');
    }
}

