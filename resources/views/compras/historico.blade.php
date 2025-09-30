<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Histórico de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Gerar Relatório de Compras (PDF)</h3>
                    <form action="{{ route('compras.pdf') }}" method="GET" target="_blank" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="data_fim" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                            <input type="date" name="data_fim" id="data_fim" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <button type="submit"
                                    class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Gerar PDF
                            </button>
                        </div>
                    </form>
                    @if($errors->any())
                        <div class="text-red-600 text-sm mt-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Produto</th>
                                    <th scope="col" class="px-6 py-3">Data da Compra</th>
                                    <th scope="col" class="px-6 py-3">Quantidade</th>
                                    <th scope="col" class="px-6 py-3">Valor Unitário</th>
                                    <th scope="col" class="px-6 py-3">Valor Total</th>
                                    <th scope="col" class="px-6 py-3">Vendido por</th>
                                    @if(Auth::user()->isAdmin)
                                        <th scope="col" class="px-6 py-3">Comprado por</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($compras as $compra)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img src="{{ $compra->produto->foto ? asset('storage/'.$compra->produto->foto) : 'https://placehold.co/40x40/e2e8f0/adb5bd?text=N/A' }}"
                                                     alt="Foto do produto" class="h-10 w-10 object-cover rounded-md mr-3">
                                                <span>{{ $compra->produto->nome }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4">{{ $compra->quantidade }}</td>
                                        <td class="px-6 py-4">R$ {{ number_format($compra->valor_unitario, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 font-bold">R$ {{ number_format($compra->valor_total, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ $compra->vendedor->name }}</td>
                                        @if(Auth::user()->isAdmin)
                                            <td class="px-6 py-4">{{ $compra->comprador->name }}</td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->isAdmin ? '7' : '6' }}" class="text-center py-10 text-gray-500">
                                            @if(Auth::user()->isAdmin)
                                                Nenhuma compra foi realizada no sistema ainda.
                                            @else
                                                Você ainda não realizou nenhuma compra.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $compras->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
