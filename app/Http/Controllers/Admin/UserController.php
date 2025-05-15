<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telefone' => 'nullable|string|max:20',
            'padrinho' => 'nullable|string|max:255',
            'ano_de_ingresso' => 'nullable|integer',
            'password' => 'required|string|min:8|confirmed',
            'admin' => 'required|string|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'padrinho' => $request->padrinho,
            'ano_de_ingresso' => $request->ano_de_ingresso,
            'password' => Hash::make($request->password),
            'admin' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telefone' => 'nullable|string|max:20',
            'padrinho' => 'nullable|string|max:255',
            'ano_de_ingresso' => 'nullable|integer',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'padrinho' => $request->padrinho,
            'ano_de_ingresso' => $request->ano_de_ingresso,
            'admin' => (int) $request->role,
        ];
        

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso!');
    }
} 