<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gerenciamento de Usuários') }}
            </h2>
            <a href="{{ route('users.create') }}" class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                + Novo Usuário
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Foto</th>
                                    <th scope="col" class="px-6 py-3">Nome</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Criado por</th>
                                    <th scope="col" class="px-6 py-3 text-center">Admin</th>
                                    <th scope="col" class="px-6 py-3 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <img src="{{ $user->foto ? asset('storage/'.$user->foto) : 'https://placehold.co/60x60/e2e8f0/adb5bd?text=Perfil' }}"
                                                 alt="Foto do usuário" class="h-12 w-12 object-cover rounded-full">
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">{{ $user->creator->name ?? 'Sistema' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->isAdmin ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $user->isAdmin ? 'Sim' : 'Não' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center items-center gap-4">
                                                
                                                
                                                
                                                @can('update', $user)
                                                    <a href="{{ route('users.edit', $user->id) }}" class="font-medium text-blue-600 hover:underline">Editar</a>
                                                @endcan
                                                
                                                @can('delete', $user)
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja excluir este usuário?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 hover:underline">Excluir</button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10 text-gray-500">Nenhum usuário encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

