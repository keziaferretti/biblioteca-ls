@extends('layouts.app')

@section('title', 'Editoras — Biblioteca LMS')
@section('page-title', 'Editoras')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">{{ $data->total() }} editora(s) cadastrada(s)</p>
        <a href="{{ route('publishers.create') }}" class="btn btn-primary-accent">
            <i class="bi bi-plus-lg"></i> Nova Editora
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Livros</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $publisher)
                        <tr>
                            <td>{{ $publisher->id }}</td>
                            <td>{{ $publisher->name }}</td>
                            <td>{{ $publisher->email }}</td>
                            <td>{{ $publisher->phone ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ $publisher->books_count ?? 0 }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('publishers.show', $publisher->id) }}" class="btn btn-sm btn-outline-secondary" title="Visualizar"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('publishers.edit', $publisher->id) }}" class="btn btn-sm btn-outline-primary-accent" title="Editar"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmAndDelete('{{ route('publishers.destroy', $publisher->id) }}', '{{ route('publishers.index') }}')"
                                        title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhuma editora cadastrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $data->links() }}</div>
@endsection
