@extends('layouts.app')

@section('title', 'Cliente #' . $data->id)
@section('page-title', 'Detalhes do Cliente')

@section('content')
    <div class="card p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-8"><strong>Nome:</strong> {{ $data->name }}</div>
            <div class="col-md-4"><strong>CPF:</strong> {{ $data->document }}</div>
            <div class="col-md-6"><strong>E-mail:</strong> {{ $data->email }}</div>
            <div class="col-md-6"><strong>Telefone:</strong> {{ $data->phone ?? '—' }}</div>
            <div class="col-md-4"><strong>Nascimento:</strong>
                {{ $data->birth_date ? \Carbon\Carbon::parse($data->birth_date)->format('d/m/Y') : '—' }}
            </div>
            <div class="col-md-8"><strong>Endereço:</strong> {{ $data->address ?? '—' }}</div>
            <div class="col-md-6"><strong>Empréstimos ativos:</strong> {{ $data->active_loans_count ?? 0 }}</div>
            <div class="col-md-6"><strong>Cadastrado em:</strong> {{ $data->created_at?->format('d/m/Y H:i') }}</div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Voltar</a>
            <a href="{{ route('customers.edit', $data->id) }}" class="btn btn-primary-accent">Editar</a>
        </div>
    </div>

    @if ($data->loans && $data->loans->count() > 0)
        <div class="card">
            <div class="card-header bg-white"><strong>Histórico de Empréstimos</strong></div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr><th>#</th><th>Livro</th><th>Empréstimo</th><th>Devolução prevista</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($data->loans as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>{{ $loan->book?->title ?? '—' }}</td>
                                <td>{{ optional($loan->loan_date)->format('d/m/Y') }}</td>
                                <td>{{ optional($loan->due_date)->format('d/m/Y') }}</td>
                                <td><span class="badge badge-status-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
