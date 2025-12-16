<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\JornadaAspiranteUser;
use App\Models\DesafioUser;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->get();

        return view('admin.users.index', compact('users'));
    }

    public function show(Request $request)
    {
        $user = User::findOrFail($request->id);

        $desafiosJornada = JornadaAspiranteUser::select('jornada_aspirante_user.*', 'jornada_aspirante_user.id as desafio_user_id', 'jornada_aspirante.*') 
            ->leftJoin('jornada_aspirante', 'jornada_aspirante_user.jornada_aspirante_id', '=', 'jornada_aspirante.id')
            ->where('jornada_aspirante_user.user_id', $user->id)
            ->get();

        $desafios = DesafioUser::select('desafio_user.*','desafio_user.id as desafio_user_id', 'desafios.*') 
            ->leftJoin('desafios', 'desafio_user.desafio_id', '=', 'desafios.id')
            ->where('desafio_user.user_id', $user->id)
            ->get();

        $conquistas = $user->conquistas()
            ->withPivot('conquistado_em')
            ->get();

        $totalPontos = JornadaAspiranteUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->join('jornada_aspirante', 'jornada_aspirante.id', '=', 'jornada_aspirante_user.jornada_aspirante_id')
            ->sum('jornada_aspirante.pontos');

        $totalPontosDesafios = DesafioUser::where('user_id', $user->id)
            ->where('concluido', 1)
            ->join('desafios', 'desafios.id', '=', 'desafio_user.desafio_id')
            ->sum('desafios.pontos');
       
        $totalPontos = $totalPontos + $totalPontosDesafios;

        return view('admin.users.show', compact('user', 'desafios', 'desafiosJornada', 'totalPontos', 'conquistas'));
    }

    public function addPontuacaoJornada(Request $request)
    {
        $jornada = JornadaAspiranteUser::findOrFail($request->id);
        
        $jornada->update([
            'concluido' => 1,
        ]);

        return redirect()->back()->with('success', 'Pontuação atualizada com sucesso!');
    }

    public function removerPontuacaoJornada(Request $request)
    {
        $jornada = JornadaAspiranteUser::findOrFail($request->id);
        
        $jornada->update([
            'concluido' => 0,
        ]);

        return redirect()->back()->with('success', 'Pontuação atualizada com sucesso!');
    }

    public function addPontuacaoDesafioJunior(Request $request)
    {
        $jornada = DesafioUser::findOrFail($request->desafio_id);

        $jornada->update([
            'concluido' => 1,
        ]);

        return redirect()->back()->with('success', 'Pontuação atualizada com sucesso!');
    }


    public function removerPontuacaoDesafioJunior(Request $request)
    {
        $jornada = DesafioUser::findOrFail($request->desafio_id);

        $jornada->update([
            'concluido' => 0,
        ]);

        return redirect()->back()->with('success', 'Pontuação atualizada com sucesso!');
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

    public function generateCurriculoJunior($id)
    {
        $user = User::findOrFail($id);
        
            $pdf = PDF::loadView('admin.users.curriculo-junior-pdf', compact('user'))
              ->setPaper('a4', 'portrait')
              ->setOption('isRemoteEnabled', true)
              ->setOption('isHtml5ParserEnabled', true);
     
        return $pdf->stream('curriculo-junior-' . $user->name . '.pdf');
    }
} 