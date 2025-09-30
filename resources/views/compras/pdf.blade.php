<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Compras</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .container { width: 100%; margin: 0 auto; }
        .header, .footer { width: 100%; text-align: center; position: fixed; }
        .header { top: 0px; }
        .footer { bottom: 0px; font-size: 10px; color: #777; }
        .content { margin-top: 120px; }
        h1 { font-size: 20px; text-align: center; margin-bottom: 5px; }
        h2 { font-size: 14px; text-align: center; margin-top: 0; color: #555; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .total-row td { font-weight: bold; background-color: #f9f9f9; }
        .text-right { text-align: right; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Compras</h1>
        <h2>Período de {{ $periodo['inicio'] }} a {{ $periodo['fim'] }}</h2>
        <p style="font-size: 11px; color: #666;">
            @if(Auth::user()->isAdmin)
                Relatório completo do sistema
            @else
                Emitido para: {{ $user->name }} ({{ $user->email }})
            @endif
        </p>
    </div>

    <div class="footer">
        Gerado em {{ now()->format('d/m/Y H:i') }} - Página <span class="pagenum"></span>
    </div>

    <div class="content">
        @if($compras->isEmpty())
            <p style="text-align: center; margin-top: 50px;">Nenhuma compra encontrada para o período selecionado.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Vendido por</th>
                        @if(Auth::user()->isAdmin)
                            <th>Comprado por</th>
                        @endif
                        <th class="text-right">Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                        <tr>
                            <td>{{ $compra->created_at->format('d/m/Y') }}</td>
                            <td>{{ $compra->produto->nome }}</td>
                            <td>{{ $compra->produto->categoria }}</td>
                            <td>{{ $compra->vendedor->name }}</td>
                            @if(Auth::user()->isAdmin)
                                <td>{{ $compra->comprador->name }}</td>
                            @endif
                            <td class="text-right">R$ {{ number_format($compra->valor_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="{{ Auth::user()->isAdmin ? '5' : '4' }}"><strong>Total Geral</strong></td>
                        <td class="text-right"><strong>R$ {{ number_format($compras->sum('valor_total'), 2, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
