<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CurriculoJuniorController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('curriculo.index', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'name' => 'required',
            'telefone' => 'nullable',
            'data_nascimento' => 'required|date',
            'ano_de_ingresso' => 'nullable|numeric',
            'avatar' => 'nullable|image|max:2072',
            'padrinho' => 'required',
            'cargo' => 'required',
            'eventos' => 'nullable',
            'comissoes' => 'nullable',
            'concursos_participados' => 'nullable',
            'premiacoes' => 'nullable',
            'empresas_vinculos' => 'nullable',
            'outros_cursos' => 'nullable|required_if:outro,on'
        ],
        [
            'avatar.max' => 'O tamanho máximo permitido para o avatar é 2MB.',
            'avatar.image' => 'O arquivo enviado deve ser uma imagem.',
            'avatar.uploaded' => 'O tamanho máximo permitido para o avatar é 2MB.',
        ]);

        $data = $request->only([
            'email',
            'name',
            'telefone',
            'data_nascimento',
            'ano_de_ingresso',
            'padrinho',
            'cargo',
            'eventos',
            'comissoes',
            'concursos_participados',
            'premiacoes',
            'empresas_vinculos',
            'outros_cursos',
            'curso_facilitador',
        ]);

        $user = auth()->user();
        
        if ($request->hasFile('avatar')) {
 
            if ($user->avatar) {
                Storage::delete('avatars/' . $user->avatar);
            }
    
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = basename($avatarPath);
        }

        // Campos booleanos
        $booleanFields = [
            'adm', 'admin_curso', 'impact', 'archieve', 'responsabilidade', 'reunioes',
            'networking', 'mentoring', 'explore', 'envolva', 'contruindo_fundacao',
            'elaborando_mensagem', 'entrega_mensagem', 'gestao_marketing', 'lideranca',
            'facilitador', 'gerenciamento_projeto', 'discover', 'apresentador', 'oratoria',
             'outro'
        ];

        foreach ($booleanFields as $field) {
            $data[$field] = $request->has($field) && $request->input($field) === 'on';
        }

        if (!$data['outro']) {
            $data['outros_cursos'] = null;
        }

        auth()->user()->update($data);

        return redirect()->route('curriculo.success')->with('success', 'Currículo atualizado com sucesso!');
    }

    public function success()
    {
        return view('curriculo.success');
    }
}
