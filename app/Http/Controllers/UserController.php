<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $users = User::with('creator')->latest()->paginate(10);
        return view('admin.users.crud', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cpf' => ['required', 'string', 'max:14'],
            'dNasc' => ['required', 'date'],
            'cep' => ['required', 'string', 'max:9'],
            'logradouro' => ['required', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:2'],
            'saldo' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'isAdmin' => ['boolean']
        ]);

        $data = $request->except('password', 'foto');
        $data['password'] = Hash::make($request->password);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('profile-photos', 'public');
        }

        $data['isAdmin'] = $request->has('isAdmin');

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Utilizador criado com sucesso.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'cpf' => ['required', 'string', 'max:14'],
            'dNasc' => ['required', 'date'],
            'cep' => ['required', 'string', 'max:9'],
            'logradouro' => ['required', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:2'],
            'saldo' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'isAdmin' => ['boolean']
        ]);

        $data = $request->except('password', 'foto', 'password_confirmation');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
           
            $data['foto'] = $request->file('foto')->store('profile-photos', 'public');
        }

        $data['isAdmin'] = $request->has('isAdmin');

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Utilizador atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilizador excluído com sucesso.');
    }

    public function cepApi($cep)
    {
        $cep = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            return response()->json(['error' => 'CEP inválido.'], 400);
        }

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->failed() || isset($response->json()['erro'])) {
            return response()->json(['error' => 'CEP não encontrado.'], 404);
        }

        return response()->json($response->json());
    }
}

