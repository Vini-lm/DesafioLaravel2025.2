<x-app-layout>
<x-slot name="header">
<div class="flex flex-col md:flex-row justify-between items-center gap-4">
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
{{ __('Página Inicial') }}
</h2>


        <form method="GET" action="{{ route('home_page') }}" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-end">
            
        
            <div class="w-full md:w-auto">
                <label for="search" class="sr-only">Pesquisar</label>
                <input name="search" id="search" type="text" placeholder="Pesquisar por nome, categoria..."
                    
                        value="{{ $search ?? '' }}" 
                        class="border-gray-300 rounded-lg p-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
            </div>

         
            <div class="w-full md:w-auto">
                <label for="categoria" class="sr-only">Categoria</label>
                <select name="categoria" id="categoria" class="border-gray-300 rounded-lg p-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todas as Categorias</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria }}" {{ $categoria == ($categoriaSelecionada ?? '') ? 'selected' : '' }}>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>
            </div>

        
            <div class="flex gap-2 w-full md:w-auto">
              
                <button type="submit" class="w-full md:w-auto justify-center text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Filtrar / Buscar
                </button>
             
                <a href="{{ route('home_page') }}" class="w-full md:w-auto text-center bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Limpar
                </a>
            </div>
        </form>
    </div>
</x-slot>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
               
                @if (count($produtos) === 0)
                    <p class="text-center text-gray-500">Nenhum produto encontrado com os critérios de busca/filtro.</p>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full bg-white">
                      
                        <thead>
                            <tr class="border-b">
                                <th class="px-4 py-2 text-left">Nome</th>
                                <th class="px-4 py-2 text-left">Descrição</th>
                                <th class="px-4 py-2 text-left">Preço</th>
                                <th class="px-4 py-2 text-left">Categoria</th>
                                <th class="px-4 py-2 text-left">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtos as $produto)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $produto->nome }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($produto->desc, 50) }}</td>
                                    <td class="px-4 py-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $produto->categoria }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('produtos.pvi', $produto) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>