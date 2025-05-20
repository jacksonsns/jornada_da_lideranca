@extends('layouts.app')

@section('title', 'Currículo Cadastrado')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sucesso!</div>
                <div class="card-body text-center">
                    <h3>Currículo atualizado com sucesso!</h3>
                    <p>Obrigado por se cadastrar. Seu currículo foi atualizado em nosso sistema.</p>
                    <a href="{{ route('curriculo.index') }}" class="btn btn-primary">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 