<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-12 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row gap-8 md:gap-12">
                        
                        <div class="md:w-1/2">
                            <img src="{{ $produto->foto ? asset('storage/' . $produto->foto) : 'https://placehold.co/600x600/e2e8f0/adb5bd?text=Produto' }}" 
                                 alt="{{ $produto->nome }}" 
                                 class="w-full h-auto rounded-lg shadow-md object-cover aspect-square">
                        </div>
                        
                        <div class="md:w-1/2 flex flex-col">
                            <h1 class="text-4xl font-bold text-gray-900">{{ $produto->nome }}</h1>
                            <span class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold mt-2 mr-2 px-2.5 py-0.5 rounded-full w-max">{{ $produto->categoria }}</span>

                            <p class="text-gray-600 mt-4 text-base leading-relaxed flex-grow">{{ $produto->desc }}</p>

                            <div class="mt-6">
                                <p class="text-sm text-gray-500">Estoque disponível: <span class="font-bold text-gray-700">{{ $produto->quantidade }} unidades</span></p>
                                <p class="text-5xl font-extrabold text-indigo-600 my-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                            </div>
                            
                            <hr class="my-6">

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Informações do Vendedor</h3>
                                <p class="text-gray-600 mt-2"><strong>Nome:</strong> {{ $produto->vendedor->name ?? 'Desconhecido' }}</p>
                                <p class="text-gray-600"><strong>Contato (E-mail):</strong> {{ $produto->vendedor->email ?? 'Não disponível' }}</p>
                            </div>

                            <div class="mt-8 flex gap-4">
                                <a href="{{ url()->previous() }}" class="flex-1 text-center bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                                    Voltar
                                </a>

                                @if(!Auth::user()->isAdmin)
                                    <a href="{{ route('produtos.comprar', $produto->id) }}" class="flex-1 text-center bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300">
                                        Comprar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
