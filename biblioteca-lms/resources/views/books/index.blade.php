@extends('layouts.app')

@section('title', 'Livros — Biblioteca LMS')
@section('page-title', 'Livros')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">{{ $data->total() }} livro(s) cadastrado(s)</p>
        <a href="{{ route('books.create') }}" class="btn btn-primary-accent">
            <i class="bi bi-plus-lg"></i> Novo Livro
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Editora</th>
                        <th>Ano</th>
                        <th>Disponíveis</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher?->name ?? '—' }}</td>
                            <td>{{ $book->publication_year }}</td>
                            <td>
                                <span class="badge {{ $book->available_copies > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $book->available_copies }}/{{ $book->total_copies }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary-accent"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmAndDelete('{{ route('books.destroy', $book->id) }}', '{{ route('books.index') }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhum livro cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $data->links() }}</div>
@endsection
