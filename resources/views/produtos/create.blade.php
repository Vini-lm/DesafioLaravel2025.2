<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Produto</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Cadastrar Novo Produto</h1>

    <form method="POST" action="{{ route('admin.produtos.store') }}" enctype="multipart/form-data"
          class="bg-white p-6 rounded-lg shadow space-y-4">
      @csrf

      <div>
        <label class="block font-medium">Nome</label>
        <input type="text" name="nome" class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block font-medium">Descrição</label>
        <textarea name="desc" class="w-full border rounded p-2" rows="3" required></textarea>
      </div>

      <div>
        <label class="block font-medium">Categoria</label>
        <input type="text" name="categoria" class="w-full border rounded p-2" required>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block font-medium">Preço</label>
          <input type="number" step="0.01" name="preco" class="w-full border rounded p-2" required>
        </div>
        <div>
          <label class="block font-medium">Quantidade</label>
          <input type="number" name="quantidade" class="w-full border rounded p-2" required>
        </div>
      </div>

      <div>
        <label class="block font-medium">Foto</label>
        <input type="file" name="foto" class="w-full border rounded p-2">
      </div>

      <div class="flex gap-4">
        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          Salvar
        </button>
        <a href="{{ route('admin.produtos.manage') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</body>
</html>
