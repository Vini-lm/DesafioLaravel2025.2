<x-app-layout>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gerenciamento de Produtos') }}
            </h2>

           
            @if(!Auth::user()->isAdmin)
                <a href="{{ route('admin.produtos.create') }}"
                   class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                    + Novo Produto
                </a>
            @endif
        </div>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

           
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            
            @if(Auth::user()->isAdmin && isset($chart))
                <div class="mb-8 bg-white p-6 rounded-lg shadow-sm">
                    {!! $chart->container() !!}
                </div>
            @endif

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($produtos->isEmpty())
                        <p class="text-center text-gray-500 py-10">
                            @if(Auth::user()->isAdmin)
                                Nenhum produto cadastrado no sistema ainda.
                            @else
                                Você ainda não possui nenhum produto cadastrado. <a href="{{ route('admin.produtos.create') }}" class="text-blue-600 hover:underline">Clique aqui para criar o primeiro.</a>
                            @endif
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Foto</th>
                                        <th scope="col" class="px-6 py-3">Nome</th>
                                        <th scope="col" class="px-6 py-3">Categoria</th>
                                        <th scope="col" class="px-6 py-3">Preço</th>
                                        <th scope="col" class="px-6 py-3 text-center">Estoque</th>
                                        @if(Auth::user()->isAdmin)
                                            <th scope="col" class="px-6 py-3">Vendedor</th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produtos as $produto)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <img src="{{ $produto->foto ? asset('storage/'.$produto->foto) : 'https://placehold.co/60x60/e2e8f0/adb5bd?text=Produto' }}"
                                                     alt="Foto do produto" class="h-12 w-12 object-cover rounded-md">
                                            </td>
                                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $produto->nome }}</td>
                                            <td class="px-6 py-4">{{ $produto->categoria }}</td>
                                            <td class="px-6 py-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center">{{ $produto->quantidade }}</td>
                                            
                                            @if(Auth::user()->isAdmin)
                                                <td class="px-6 py-4">{{ $produto->vendedor->name ?? 'N/A' }}</td>
                                            @endif

                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center items-center gap-4">
                                                    <a href="{{ route('admin.produtos.edit', $produto->id) }}" class="font-medium text-blue-600 hover:underline">Editar</a>
                                                    <form action="{{ route('admin.produtos.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-red-600 hover:underline">Excluir</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    
    @if(Auth::user()->isAdmin && isset($chart))
        {!! $chart->script() !!}
    @endif
</x-app-layout>
