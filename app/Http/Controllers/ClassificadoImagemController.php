<?php

namespace App\Http\Controllers;

use App\Models\Classificado;
use App\Models\ClassificadoImagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClassificadoImagemController extends Controller
{
    public function destroy(ClassificadoImagem $imagem)
    {
        // Verifica se o usuário é o dono do anúncio
        if ($imagem->classificado->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Não autorizado'], 403);
        }

        // Remove o arquivo do storage
        Storage::delete($imagem->caminho);

        // Remove o registro do banco
        $imagem->delete();

        return response()->json(['success' => true]);
    }
} 