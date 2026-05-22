@extends('layouts.app')

@section('title', 'Empréstimo #' . $data->id)
@section('page-title', 'Detalhes do Empréstimo')

@section('content')
    <div class="card p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <strong>Livro:</strong>
                @if ($data->book)
                    <a href="{{ route('books.show', $data->book->id) }}">{{ $data->book->title }}</a>
                @else
                    —
                @endif
            </div>
            <div class="col-md-6">
                <strong>Editora:</strong> {{ $data->book?->publisher?->name ?? '—' }}
            </div>
            <div class="col-md-6">
                <strong>Cliente:</strong>
                @if ($data->customer)
                    <a href="{{ route('customers.show', $data->customer->id) }}">{{ $data->customer->name }}</a>
                @else
                    —
                @endif
            </div>
            <div class="col-md-6">
                <strong>Documento:</strong> {{ $data->customer?->document ?? '—' }}
            </div>
            <div class="col-md-4">
                <strong>Data do Empréstimo:</strong> {{ optional($data->loan_date)->format('d/m/Y') ?? '—' }}
            </div>
            <div class="col-md-4">
                <strong>Devolução Prevista:</strong> {{ optional($data->due_date)->format('d/m/Y') ?? '—' }}
            </div>
            <div class="col-md-4">
                <strong>Devolvido em:</strong>
                {{ $data->returned_at ? $data->returned_at->format('d/m/Y H:i') : '—' }}
            </div>
            <div class="col-md-4">
                <strong>Status:</strong>
                <span class="badge badge-status-{{ $data->status }}">{{ ucfirst($data->status) }}</span>
            </div>
            <div class="col-md-4">
                <strong>Registrado em:</strong> {{ $data->created_at?->format('d/m/Y H:i') }}
            </div>
            <div class="col-md-4">
                <strong>Atualizado em:</strong> {{ $data->updated_at?->format('d/m/Y H:i') }}
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">Voltar</a>
            @if ($data->status !== 'returned')
                <button type="button" class="btn btn-success"
                        onclick="returnLoan('{{ route('loans.return', $data->id) }}', '{{ route('loans.index') }}')">
                    <i class="bi bi-arrow-return-left"></i> Registrar Devolução
                </button>
            @endif
            <a href="{{ route('loans.edit', $data->id) }}" class="btn btn-primary-accent">Editar</a>
        </div>
    </div>
@endsection
