<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'telefone' => ['nullable', 'string', 'max:15'],
            'padrinho' => ['nullable', 'string', 'max:255'],
            'ano_de_ingresso' => ['nullable'],
        ]);
      
        $user->name = $validados['name'];
        $user->email = $validados['email'];
    
        // Atualizando a senha se preenchida
        if ($request->filled('password')) {
            $user->password = Hash::make($validados['password']);
        }
    
        $user->telefone = $validados['telefone'] ?? $user->telefone;
        $user->padrinho = $validados['padrinho'] ?? $user->padrinho;
        $user->ano_de_ingresso = $validados['ano_de_ingresso'] ?? $user->ano_de_ingresso;
    
        if ($request->hasFile('avatar')) {
 
            if ($user->avatar) {
                Storage::delete('avatars/' . $user->avatar);
            }
    
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = basename($avatarPath);
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