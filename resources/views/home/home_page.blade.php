<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/home_page.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Página inicial</title>
</head>

<body>
    <div>
        <div class="overflow-x-auto border border-gray-300 rounded-lg p-4 m-4" style="width: 80%; margin: auto;">

    <!-- -->
            <form method="GET" action="{{ route('produtos.search') }}" class="mb-4 flex gap-2">
                <input name="search" type="text" placeholder="Pesquisar..."
                       class="border rounded-lg p-2 w-full">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Buscar
                </button>
            </form>

           
            <table class="w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Quantidade em Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $produto)
                    <tr class="hover:bg-blue-100 text-center">
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->desc }}</td>
                        <td>R$ {{ number_format($produto->preco,2,',','.') }}</td>
                        <td>{{ $produto->categoria }}</td>
                        <td>{{ $produto->quantidade }}</td>
                        <td class="flex justify-center gap-2 p-2">
                            
                            <a href="{{ route('produtos.show', $produto->id) }}"
                               class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-700">
                                Ver
                            </a>
                            
                            <a href="{{ route('produtos.comprar', $produto->id) }}"
                               class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700">
                                Comprar
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
