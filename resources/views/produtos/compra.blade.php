<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Comprar: {{ $produto->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row gap-8">
                        <img src="{{ $produto->foto ? asset('storage/'.$produto->foto) : 'https://placehold.co/400x400/e2e8f0/adb5bd?text=Produto' }}" alt="{{ $produto->nome }}" class="w-full md:w-1/3 rounded-lg object-cover self-start">
                        
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $produto->nome }}</h1>
                            <p class="text-gray-600 mt-2">{{ $produto->desc }}</p>
                            <p class="text-4xl font-extrabold text-indigo-600 my-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">Estoque disponível: {{ $produto->quantidade }} unidades</p>
                            
                            <hr class="my-6">

                            <form action="{{ route('pagseguro.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                
                                <div class="flex items-center gap-4">
                                    <label for="quantidade" class="block text-sm font-medium text-gray-700">Quantidade:</label>
                                    <input type="number" id="quantidade" name="quantidade" value="1" min="1" max="{{ $produto->quantidade }}" required 
                                           class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                @error('quantidade')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                <div class="mt-6">
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Finalizar Compra com PagSeguro
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
