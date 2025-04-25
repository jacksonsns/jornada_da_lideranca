<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->name = $validados['name'];
        $user->email = $validados['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validados['password']);
        }

        $user->save();

        return redirect()->route('perfil.index')
            ->with('sucesso', 'Perfil atualizado com sucesso!');
    }

    public function atualizarAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:1024'] // máximo 1MB
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');
        
        $user = auth()->user();
        $user->avatar = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Avatar atualizado com sucesso!',
            'path' => asset('storage/' . $path)
        ]);
    }
} 