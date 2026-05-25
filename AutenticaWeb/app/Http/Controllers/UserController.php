<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('Usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('Usuarios.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules())->stopOnFirstFailure();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'phone' => $request->phone,
            'cpf' => $request->cpf,
            'role' => $request->role,
            'password' => $request->password,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso.');
    }

    public function edit(User $user)
    {
        return view('Usuarios.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), $this->rules($user->id, $request->filled('password')))
            ->stopOnFirstFailure();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'phone' => $request->phone,
            'cpf' => $request->cpf,
            'role' => $request->role,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('usuarios.index')->with('error', 'Você não pode excluir sua própria conta.');
        }

        $user->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso.');
    }

    private function rules(?int $userId = null, bool $passwordRequired = true): array
    {
        $emailRule = 'required|email|unique:users,email';
        $cpfRule = 'required|size:14|unique:users,cpf';

        if ($userId) {
            $emailRule .= ','.$userId;
            $cpfRule .= ','.$userId;
        }

        $rules = [
            'name' => 'required|min:3',
            'email' => $emailRule,
            'phone' => 'required|min:14|max:15',
            'cpf' => $cpfRule,
            'role' => 'required|in:admin,portaria,professor,responsavel',
            'is_active' => 'nullable|boolean',
        ];

        if ($passwordRequired) {
            $rules['password'] = 'required|min:6';
        } else {
            $rules['password'] = 'nullable|min:6';
        }

        return $rules;
    }
}
