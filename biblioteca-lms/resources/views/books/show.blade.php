@extends('layouts.app')

@section('title', 'Livro #' . $data->id)
@section('page-title', 'Detalhes do Livro')

@section('content')
    <div class="card p-4">
        <div class="row g-3">
            <div class="col-md-8"><strong>Título:</strong> {{ $data->title }}</div>
            <div class="col-md-4"><strong>ISBN:</strong> {{ $data->isbn }}</div>
            <div class="col-md-6"><strong>Autor:</strong> {{ $data->author }}</div>
            <div class="col-md-6"><strong>Editora:</strong> {{ $data->publisher?->name ?? '—' }}</div>
            <div class="col-md-4"><strong>Ano de Publicação:</strong> {{ $data->publication_year }}</div>
            <div class="col-md-4"><strong>Total de Exemplares:</strong> {{ $data->total_copies }}</div>
            <div class="col-md-4">
                <strong>Disponíveis:</strong>
                <span class="badge {{ $data->available_copies > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $data->available_copies }}
                </span>
            </div>
            <div class="col-md-6"><strong>Empréstimos ativos:</strong> {{ $data->active_loans_count ?? 0 }}</div>
            <div class="col-md-6"><strong>Cadastrado em:</strong> {{ $data->created_at?->format('d/m/Y H:i') }}</div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Voltar</a>
            <a href="{{ route('books.edit', $data->id) }}" class="btn btn-primary-accent">Editar</a>
        </div>
    </div>
@endsection
