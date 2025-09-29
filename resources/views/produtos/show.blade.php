<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>{{ $produto->nome }}</title>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-2/3">
        <h1 class="text-3xl font-bold mb-4">{{ $produto->nome }}</h1>

        
        @if($produto->foto)
            <img src="{{ asset('storage/' . $produto->foto) }}" 
                 alt="{{ $produto->nome }}" 
                 class="w-64 h-64 object-cover rounded-lg mb-4">
        @else
            <p class="italic text-gray-500 mb-4">Foto não adicionada!</p>
        @endif

      
        <p class="mb-2"><strong>Descrição:</strong> {{ $produto->desc }}</p>
        <p class="mb-2"><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
        <p class="mb-2"><strong>Categoria:</strong> {{ $produto->categoria }}</p>
        <p class="mb-2"><strong>Estoque disponível:</strong> {{ $produto->quantidade }}</p>

       
        <p class="mb-2"><strong>Vendedor:</strong> {{ $produto->vendedor->name ?? 'Desconhecido' }}</p>

       
        <p class="mb-2 text-sm text-gray-600">
            <strong>Criado em:</strong> {{ $produto->created_at->format('d/m/Y H:i') }}
        </p>
        <p class="mb-4 text-sm text-gray-600">
            <strong>Atualizado em:</strong> {{ $produto->updated_at->format('d/m/Y H:i') }}
        </p>

        
        <div class="flex gap-4">
            <a href="{{ route('produtos.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Voltar
            </a>

            <a href="{{ route('produtos.comprar', $produto->id) }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Comprar
            </a>
        </div>
    </div>
</body>
</html>