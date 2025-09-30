@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
    <p class="font-bold">Ocorreram alguns erros:</p>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST"
  
    action="{{ $user->exists ? route('users.update', $user->id) : route('users.store') }}"
    class="space-y-6"
    enctype="multipart/form-data">
    @csrf
   
    @if($user->exists)
    @method('PUT')
    @endif

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required maxlength="255"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required maxlength="255"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
            <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $user->cpf ?? '') }}" placeholder="000.000.000-00" required maxlength="14"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="dNasc" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
            <input type="date" name="dNasc" id="dNasc" value="{{ old('dNasc', $user->dNasc ?? '') }}" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>

    <hr class="my-4">


    <h3 class="text-lg font-medium leading-6 text-gray-900">Endereço</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
            <input type="text" name="cep" id="cep" value="{{ old('cep', $user->cep ?? '') }}" placeholder="00000-000" required maxlength="9"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <small id="cep-feedback" class="text-sm"></small>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
        <div>
            <label for="logradouro" class="block text-sm font-medium text-gray-700">Logradouro</label>
            <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro', $user->logradouro ?? '') }}" required readonly maxlength="255"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
        </div>
        <div>
            <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro</label>
            <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $user->bairro ?? '') }}" required readonly maxlength="255"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
        </div>
        <div>
            <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
            <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $user->cidade ?? '') }}" required readonly maxlength="255"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
        </div>
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <input type="text" name="estado" id="estado" value="{{ old('estado', $user->estado ?? '') }}" required readonly maxlength="2"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
        </div>
        <div>
            <label for="complemento" class="block text-sm font-medium text-gray-700">Complemento</label>
            <input type="text" name="complemento" id="complemento" value="{{ old('complemento', $user->complemento ?? '') }}" maxlength="255"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
    </div>

    <hr class="my-4">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="saldo" class="block text-sm font-medium text-gray-700">Saldo (R$)</label>
            <input type="number" step="0.01" name="saldo" id="saldo" value="{{ old('saldo', $user->saldo ?? '0.00') }}" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="foto" class="block text-sm font-medium text-gray-700">Foto de Perfil</label>
            <input type="file" name="foto" id="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @if($user->exists && $user->foto)
            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto atual" class="mt-2 h-16 w-16 rounded-full object-cover">
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" name="password" id="password" {{ $user->exists ? '' : 'required' }}
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @if($user->exists)<small class="text-gray-500">Deixe em branco para não alterar.</small>@endif
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" {{ $user->exists ? '' : 'required' }}
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>


    <div class="flex items-center">
        <input id="isAdmin" name="isAdmin" type="checkbox" value="1" {{ old('isAdmin', $user->exists && $user->isAdmin) ? 'checked' : '' }}
            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
        <label for="isAdmin" class="ml-2 block text-sm text-gray-900">
            É Administrador?
        </label>
    </div>


    <div class="flex items-center justify-end gap-4 pt-4">
        <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ $user->exists ? 'Atualizar Usuário' : 'Salvar Usuário' }}
        </button>
    </div>
</form>




<script>
    document.getElementById('cep').addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, '');
        const feedback = document.getElementById('cep-feedback');

        if (cep.length === 8) {
            feedback.textContent = 'Buscando...';
            feedback.style.color = 'orange';


            fetch(`/api/cep/${cep}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('CEP não encontrado');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.erro) {
                        throw new Error('CEP não encontrado');
                    }
                    document.getElementById('logradouro').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                    feedback.textContent = 'CEP encontrado!';
                    feedback.style.color = 'green';
                })
                .catch(error => {
                    feedback.textContent = error.message;
                    feedback.style.color = 'red';

                    document.getElementById('logradouro').value = '';
                    document.getElementById('bairro').value = '';
                    document.getElementById('cidade').value = '';
                    document.getElementById('estado').value = '';
                });
        } else {
            feedback.textContent = 'CEP inválido.';
            feedback.style.color = 'red';
        }
    });
</script>

