<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Desafio;
use App\Models\DesafioUser;
use App\Models\ModuloEscolaLideres;
use App\Models\Projeto;
use App\Models\Evento;
use App\Models\Conquista;
use App\Models\JornadaAspirante;
use App\Models\Aula;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\ProjetoIndividual;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $usuariosAtivos = User::count();
        $totalDesafios = Desafio::count();
        $desafiosCompletados = DesafioUser::where('concluido', 1)->count();
        $totalProjetos = ProjetoIndividual::count();
        
        // Dados para gráficos
        $usuariosPorMes = User::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('mes')
        ->get();

        $desafiosPorStatus = DesafioUser::select('concluido', DB::raw('COUNT(*) as total'))
            ->groupBy('concluido')
            ->get();

        $usuarios = User::select('users.*')
            ->selectSub(function ($query) {
                $query->from('desafio_user')
                    ->join('desafios', 'desafios.id', '=', 'desafio_user.desafio_id')
                    ->whereColumn('desafio_user.user_id', 'users.id')
                    ->where('desafio_user.concluido', 1)
                    ->selectRaw('COALESCE(SUM(desafios.pontos), 0)');
            }, 'total_pontos_desafios')
            ->selectSub(function ($query) {
                $query->from('jornada_aspirante_user')
                    ->join('jornada_aspirante', 'jornada_aspirante.id', '=', 'jornada_aspirante_user.jornada_aspirante_id')
                    ->whereColumn('jornada_aspirante_user.user_id', 'users.id')
                    ->where('jornada_aspirante_user.concluido', 1)
                    ->selectRaw('COALESCE(SUM(jornada_aspirante.pontos), 0)');
            }, 'total_pontos_jornadas')
            ->paginate(15);
        
        $desafiosPopulares = Desafio::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();

        $proximosEventos = Evento::where('created_at', '>=', now())
            ->orderBy('created_at')
            ->take(5)
            ->get();

        $totalModulos = ModuloEscolaLideres::count();

        return view('dashboard-admin', compact(
            'totalUsuarios',
            'usuariosAtivos',
            'totalDesafios',
            'desafiosCompletados',
            'totalModulos',
            'totalProjetos',
            'usuariosPorMes',
            'desafiosPorStatus',
            'usuarios',
            'desafiosPopulares',
            'proximosEventos',
        ));
    }


    public function desafiosIndex()
    {
        $desafios = Desafio::withCount('users')
            ->with(['users' => function($query) {
                $query->where('concluido', 1);
            }])
            ->latest()
            ->paginate(10);

        return view('admin.desafios.index', compact('desafios'));
    }

    public function desafioStore(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'pontos' => 'required|integer|min:1',
            'prazo' => 'nullable|date',
            'tipo' => 'required|in:diario,semanal,mensal',
        ]);

        Desafio::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Desafio criado com sucesso!'
        ]);
    }

    public function desafioUpdate(Request $request, Desafio $desafio)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'pontos' => 'required|integer|min:1',
            'prazo' => 'nullable|date',
            'tipo' => 'required|in:diario,semanal,mensal',
        ]);

        $desafio->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Desafio atualizado com sucesso!'
        ]);
    }

    public function desafioDestroy(Desafio $desafio)
    {
        $desafio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Desafio excluído com sucesso!'
        ]);
    }

    public function jornadaIndex()
    {
        $jornadas = JornadaAspirante::orderBy('ordem')->paginate(10);
        return view('admin.jornada.index', compact('jornadas'));
    }

    public function jornadaStore(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'pontos' => 'nullable|string|max:100',
            'ordem' => 'required|integer|min:1',
            'obrigatorio' => 'required|boolean'
        ]);

        JornadaAspirante::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Jornada criada com sucesso!'
        ]);
    }

    public function jornadaUpdate(Request $request, JornadaAspirante $jornada)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'pontos' => 'nullable|string|max:100',
            'ordem' => 'required|integer|min:1',
            'obrigatorio' => 'required|boolean'
        ]);

        $jornada->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Jornada atualizada com sucesso!'
        ]);
    }

    public function jornadaDestroy(JornadaAspirante $jornada)
    {
        $jornada->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jornada excluída com sucesso!'
        ]);
    }

    public function aulasIndex()
    {
        $aulas = Aula::with('modulo')
            ->orderBy('modulo_escola_lideres_id')
            ->orderBy('ordem')
            ->paginate(10);

        $modulos = ModuloEscolaLideres::orderBy('ordem')->get();

        return view('admin.aulas.index', compact('aulas', 'modulos'));
    }

    public function aulaStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modulo_escola_lideres_id' => 'required|exists:modulos_escola_lideres,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'conteudo' => 'required|string',
            'video_url' => 'nullable|url',
            'material' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240',
            'duracao_minutos' => 'required|integer|min:1',
            'ordem' => 'required|integer|min:1'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $data = $request->all();
    
        if ($request->hasFile('material')) {
            $file = $request->file('material');
            $path = $file->store('aulas/materiais', 'public');
            $data['material_url'] = $path;
        }
    
        Aula::create($data);
    
        return redirect()->back()->with('success', 'Aula criada com sucesso!');
    }

    public function aulaUpdate(Request $request, Aula $aula)
    {
        $validator = Validator::make($request->all(), [
            'modulo_escola_lideres_id' => 'required|exists:modulos_escola_lideres,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'conteudo' => 'required|string',
            'video_url' => 'nullable|url',
            'material' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240',
            'duracao_minutos' => 'required|integer|min:1',
            'ordem' => 'required|integer|min:1'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $request->all();
    
        if ($request->hasFile('material')) {
            if ($aula->material_url) {
                $caminhoAntigo = 'public/materiais/' . basename($aula->material_url);
                Storage::delete($caminhoAntigo);
            }
    
            $material = $request->file('material');
            $nomeArquivo = time() . '_' . $material->getClientOriginalName();
            $material->storeAs('public/materiais', $nomeArquivo);
            $data['material_url'] = 'materiais/' . $nomeArquivo;
        }
    
        try {
            $aula->update($data);
    
            return redirect()->back()->with('success', 'Aula atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar a aula: ' . $e->getMessage());
        }
    }    

    public function aulaDestroy(Aula $aula)
    {
        try {
            $aula->delete();
    
            return redirect()->back()->with('success', 'Aula excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir a aula: ' . $e->getMessage());
        }
    }    

    public function escolaLideresIndex()
    {
        $modulos = ModuloEscolaLideres::withCount('aulas')
            ->orderBy('ordem')
            ->paginate(10);

        return view('admin.escola-lideres.index', compact('modulos'));
    }

    public function escolaLideresStore(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ordem' => 'required|integer|min:1',
            'material_url' => 'nullable|url'
        ]);

        ModuloEscolaLideres::create($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Módulo criado com sucesso!'
        ]);
    }

    public function escolaLideresUpdate(Request $request, ModuloEscolaLideres $modulo)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ordem' => 'required|integer|min:1',
            'material_url' => 'nullable|url'
        ]);

        $modulo->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Módulo atualizado com sucesso!'
        ]);
    }

    public function escolaLideresDestroy(ModuloEscolaLideres $modulo)
    {
        $modulo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Módulo excluído com sucesso!'
        ]);
    }

    // Métodos para Projetos Individuais
    public function projetosIndividuaisIndex()
    {
        $projetos = ProjetoIndividual::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.projetos-individuais.index', compact('projetos'));
    }

}
