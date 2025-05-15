@extends('layouts.app-admin')

@section('content')
<div class="main_content_iner">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>Gerenciamento de Usuários</h4>
                    </div>

                    <div class="QA_table mb_30">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table lms_table_active">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Padrinho</th>
                                    <th>Ano de Ingresso</th>
                                    <th>Tipo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->telefone ?? '-' }}</td>
                                        <td>{{ $user->padrinho ?? '-' }}</td>
                                        <td>{{ $user->ano_de_ingresso ?? '-' }}</td>
                                        <td>{{ $user->admin ? 'Admin' : 'Usuário' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm me-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 