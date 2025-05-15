@extends('layouts.app-admin')

@section('content')
<div class="main_content_iner">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_tittle list_header">
                    <h4>Editar Usuário</h4>
                </div>
                <div class="white_box mb_30">
                    <div class="box_header">
                        <div class="main-title">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $user->telefone) }}">
                                    @error('telefone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="padrinho" class="form-label">Padrinho</label>
                                    <input type="text" class="form-control" id="padrinho" name="padrinho" value="{{ old('padrinho', $user->padrinho) }}">
                                    @error('padrinho')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ano_de_ingresso" class="form-label">Ano de Ingresso</label>
                                    <input type="number" class="form-control" id="ano_de_ingresso" name="ano_de_ingresso" value="{{ old('ano_de_ingresso', $user->ano_de_ingresso) }}">
                                    @error('ano_de_ingresso')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Tipo de Usuário</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="0" {{ old('role', $user->admin) == 0 ? 'selected' : '' }}>Usuário</option>
                                        <option value="1" {{ old('role', $user->admin) == 1 ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                    @error('role')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 