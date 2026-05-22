@extends('layouts.app')

@section('title', 'Clientes — Biblioteca LMS')
@section('page-title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">{{ $data->total() }} cliente(s) cadastrado(s)</p>
        <a href="{{ route('customers.create') }}" class="btn btn-primary-accent">
            <i class="bi bi-plus-lg"></i> Novo Cliente
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ativos</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->document }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ $customer->active_loans_count ?? 0 }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-primary-accent"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmAndDelete('{{ route('customers.destroy', $customer->id) }}', '{{ route('customers.index') }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhum cliente cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $data->links() }}</div>
@endsection
