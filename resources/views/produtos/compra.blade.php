<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Comprar {{ $produto->nome }}</title>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-1/2">
        <h1 class="text-2xl font-bold mb-4">Comprar {{ $produto->nome }}</h1>
        <p><strong>Preço:</strong> R$ {{ number_format($produto->preco,2,',','.') }}</p>
        <p><strong>Estoque:</strong> {{ $produto->quantidade }}</p>

        <form method="POST" action="{{ route('produtos.finalizarCompra', $produto->id) }}" class="mt-4">
            @csrf
            <label for="quantidade" class="block mb-2">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" min="1" max="{{ $produto->quantidade }}"
                   class="border p-2 rounded w-24" required>

            <button type="submit"
                    class="ml-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Finalizar Compra
            </button>
        </form>
    </div>
</body>
</html>
