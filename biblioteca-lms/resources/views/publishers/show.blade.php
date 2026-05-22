@extends('layouts.app')

@section('title', 'Editora #' . $data->id)
@section('page-title', 'Detalhes da Editora')

@section('content')
    <div class="card p-4">
        <div class="row g-3">
            <div class="col-md-6"><strong>Nome:</strong> {{ $data->name }}</div>
            <div class="col-md-6"><strong>E-mail:</strong> {{ $data->email }}</div>
            <div class="col-md-6"><strong>Telefone:</strong> {{ $data->phone ?? '—' }}</div>
            <div class="col-md-6"><strong>Website:</strong>
                @if($data->website)
                    <a href="{{ $data->website }}" target="_blank" rel="noopener">{{ $data->website }}</a>
                @else — @endif
            </div>
            <div class="col-12"><strong>Endereço:</strong> {{ $data->address ?? '—' }}</div>
            <div class="col-md-6"><strong>Livros cadastrados:</strong> {{ $data->books_count ?? 0 }}</div>
            <div class="col-md-6"><strong>Cadastrado em:</strong> {{ $data->created_at?->format('d/m/Y H:i') }}</div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('publishers.index') }}" class="btn btn-outline-secondary">Voltar</a>
            <a href="{{ route('publishers.edit', $data->id) }}" class="btn btn-primary-accent">Editar</a>
        </div>
    </div>
@endsection
