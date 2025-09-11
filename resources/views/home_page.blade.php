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


    <div >
        <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->



        <div class="overflow-x-auto border border-gray-300 rounded-lg p-4 m-4" style="width: 50%; margin: auto;">

            <input name="search" type="text" placeholder="Pesquisar" method="post" action="/search">
            <table class=" bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $produto)
                    <tr class="hover:bg-blue-100">
                        <td >{{ $produto->nome }}</td>
                        <td>{{ $produto->desc }}</td>
                        <td >{{ number_format($produto->preco,2,',','.') }}</td>
                        <td >{{ $produto->categoria }}</td>
                        <td >{{ $produto->quantidade }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>



        </div>


    </div>

</body>

</html>