@extends('layouts.app-admin')

@section('content')
<div class="admin-users-shell">
    <div class="admin-users-shell-inner">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="admin-users-card">
                    <div class="admin-users-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h4 class="mb-1 admin-users-header-title">
                                <i class="fas fa-users me-2"></i>
                                Gerenciamento de Usuários
                            </h4>
                            <p class="mb-0 admin-users-header-subtitle">
                                Busque, visualize e gerencie perfis dos participantes da Jornada da Liderança.
                            </p>
                        </div>
                    </div>

                    <div class="admin-users-card-body">
                        @if(session('success'))
                            <div class="alert alert-success admin-users-alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <form action="{{ route('admin.users.index') }}" method="GET" class="admin-users-search d-flex align-items-center flex-wrap gap-2">
                                <input type="text" name="search" class="form-control admin-users-search-input" placeholder="Buscar por nome ou email..." value="{{ request('search') }}">
                                
                                <button type="submit" class="btn admin-users-search-btn">Buscar</button>

                                @if(request('search'))
                                    <a href="{{ route('admin.users.index') }}" class="btn admin-users-search-clear">Limpar</a>
                                @endif
                            </form>
                        </div>
                        
                        <div class="table-responsive admin-users-table-wrapper">
                            <table class="table mb-0 admin-users-table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th>Padrinho</th>
                                        <th>Ano de Ingresso</th>
                                        <th>Tipo</th>
                                        <th class="text-end">Ações</th>
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
                                            <td>
                                                <span class="admin-users-badge-role {{ $user->admin ? 'role-admin' : 'role-user' }}">
                                                    {{ $user->admin ? 'Admin' : 'Usuário' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="admin-users-table-actions d-inline-flex gap-2">
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm admin-users-btn edit" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="btn btn-sm admin-users-btn view" title="Ver detalhes">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.users.curriculo-junior', $user->id) }}" class="btn btn-sm admin-users-btn pdf" target="_blank" title="Currículo Junior">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm admin-users-btn delete" onclick="return confirm('Tem certeza que deseja excluir este usuário?')" title="Excluir">
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
</div>
@endsection

@push('styles')
<style>
    .admin-users-shell {
        min-height: 100vh;
        padding: 32px 16px;
        background: radial-gradient(circle at top left, rgba(88, 101, 242, 0.22), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.18), transparent 55%),
                    linear-gradient(135deg, #020617 0%, #020617 40%, #020617 100%);
        display: flex;
        align-items: stretch;
    }

    .admin-users-shell-inner {
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
    }

    .admin-users-card {
        border-radius: 26px;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.45);
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.22), transparent 60%),
            radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.25), transparent 60%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.92), rgba(15, 23, 42, 0.97));
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.9);
    }

    .admin-users-header {
        padding: 20px 24px 18px;
        background:
            linear-gradient(120deg, rgba(37, 99, 235, 0.97), rgba(79, 70, 229, 0.97));
        border-bottom: 1px solid rgba(148, 163, 184, 0.55);
    }

    .admin-users-header-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #e5f0ff;
        letter-spacing: 0.01em;
    }

    .admin-users-header-title i {
        color: #bfdbfe;
    }

    .admin-users-header-subtitle {
        font-size: 0.86rem;
        color: rgba(226, 232, 240, 0.85);
    }

    .admin-users-card-body {
        padding: 18px 22px 22px;
    }

    .admin-users-alert-success {
        border-radius: 999px;
        border: 1px solid rgba(34, 197, 94, 0.5);
        background: radial-gradient(circle at top left, rgba(22, 163, 74, 0.18), transparent 60%),
                    rgba(15, 23, 42, 0.9);
        color: #bbf7d0;
    }

    .admin-users-search-input {
        max-width: 260px;
        background: rgba(15, 23, 42, 0.9);
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.7);
        color: #e5e7eb;
        font-size: 0.9rem;
        padding: 8px 14px;
    }

    .admin-users-search-input::placeholder {
        color: rgba(148, 163, 184, 0.9);
    }

    .admin-users-search-input:focus {
        background: rgba(15, 23, 42, 0.98);
        border-color: rgba(59, 130, 246, 0.9);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.9);
        color: #f9fafb;
    }

    .admin-users-search-btn {
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 0.86rem;
        font-weight: 600;
        border: 1px solid rgba(191, 219, 254, 0.8);
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #f9fafb;
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.7);
        transition: all 0.16s ease-out;
    }

    .admin-users-search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.9);
        color: #ffffff;
    }

    .admin-users-search-clear {
        border-radius: 999px;
        padding: 7px 14px;
        font-size: 0.84rem;
        font-weight: 500;
        border: 1px solid rgba(148, 163, 184, 0.7);
        background: rgba(15, 23, 42, 0.8);
        color: rgba(209, 213, 219, 0.9);
        transition: all 0.16s ease-out;
    }

    .admin-users-search-clear:hover {
        background: rgba(15, 23, 42, 0.95);
        color: #e5e7eb;
    }

    .admin-users-table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.98));
    }

    .admin-users-table {
        color: #e5e7eb;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        background-color: transparent;
    }

    .admin-users-table thead {
        background:
            linear-gradient(120deg, rgba(15, 23, 42, 0.96), rgba(30, 64, 175, 0.98));
    }

    .admin-users-table thead th {
        border-bottom: 1px solid rgba(148, 163, 184, 0.6);
        border-top: none;
        padding: 10px 14px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(148, 163, 184, 0.96);
        font-weight: 600;
        white-space: nowrap;
    }

    .admin-users-table tbody tr {
        transition: all 0.14s ease-out;
        background: rgba(15, 23, 42, 0.9);
    }

    .admin-users-table tbody tr:nth-child(even) {
        background: rgba(15, 23, 42, 0.96);
    }

    .admin-users-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(30, 64, 175, 0.72), rgba(15, 23, 42, 0.98));
        transform: translateY(-1px);
    }

    .admin-users-table tbody td {
        border-top: 1px solid rgba(30, 64, 175, 0.5);
        padding: 9px 14px;
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .admin-users-badge-role {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .admin-users-badge-role.role-admin {
        background: rgba(59, 130, 246, 0.15);
        color: #bfdbfe;
        border: 1px solid rgba(59, 130, 246, 0.5);
    }

    .admin-users-badge-role.role-user {
        background: rgba(22, 163, 74, 0.15);
        color: #bbf7d0;
        border: 1px solid rgba(22, 163, 74, 0.5);
    }

    .admin-users-table-actions .btn {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0;
        border: 1px solid transparent;
        font-size: 0.82rem;
        transition: all 0.16s ease-out;
    }

    .admin-users-btn.edit {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        border-color: rgba(191, 219, 254, 0.85);
        color: #eff6ff;
        box-shadow: 0 10px 26px rgba(37, 99, 235, 0.6);
    }

    .admin-users-btn.view {
        background: linear-gradient(135deg, #22c55e, #0ea5e9);
        border-color: rgba(187, 247, 208, 0.85);
        color: #ecfdf5;
        box-shadow: 0 10px 26px rgba(34, 197, 94, 0.6);
    }

    .admin-users-btn.pdf {
        background: linear-gradient(135deg, #f97316, #ea580c);
        border-color: rgba(254, 215, 170, 0.9);
        color: #1f2937;
        box-shadow: 0 10px 26px rgba(248, 171, 96, 0.7);
    }

    .admin-users-btn.delete {
        background: linear-gradient(135deg, #f97316, #dc2626);
        border-color: rgba(254, 202, 202, 0.9);
        color: #fef2f2;
        box-shadow: 0 10px 26px rgba(220, 38, 38, 0.6);
    }

    .admin-users-btn:hover {
        transform: translateY(-1px) scale(1.03);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.85);
        color: #ffffff;
    }

    @media (max-width: 991.98px) {
        .admin-users-shell {
            padding: 18px 10px 24px;
        }

        .admin-users-card {
            border-radius: 22px;
        }

        .admin-users-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
    }

    @media (max-width: 575.98px) {
        .admin-users-card-body {
            padding: 14px 12px 16px;
        }

        .admin-users-table thead th,
        .admin-users-table tbody td {
            padding: 8px 8px;
        }

        .admin-users-shell {
            padding-top: 16px;
        }
    }
</style>
@endpush