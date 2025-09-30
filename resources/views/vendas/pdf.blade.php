<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <style>
        /* Estilos para garantir que o PDF seja gerado de forma limpa e profissional */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #222;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .table-container {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f7f7f7;
            font-weight: bold;
            color: #444;
        }
        tr:nth-child(even) {
            background-color: #fdfdfd;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Relatório de Vendas</h1>
            <p>Período de {{ $periodo['inicio'] }} até {{ $periodo['fim'] }}</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Data da Venda</th>
                        <th>Produto</th>
                        <th>Comprador</th>
                        <th>Vendedor</th>
                        <th>Valor (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendas as $venda)
                        <tr>
                            <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $venda->produto->nome ?? 'Produto Removido' }}</td>
                            <td>{{ $venda->comprador->name ?? 'Comprador Removido' }}</td>
                            <td>{{ $venda->vendedor->name ?? 'Vendedor Removido' }}</td>
                            <td>{{ number_format($venda->valor_venda, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Nenhuma venda encontrada para o período selecionado.</td>
                        </tr>
                    @endforelse
                    
                   
                    @if($vendas->isNotEmpty())
                        <tr class="total-row">
                            <td colspan="4" style="text-align: right;">Total das Vendas:</td>
                            <td>{{ number_format($vendas->sum('valor_venda'), 2, ',', '.') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Relatório gerado em {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>

