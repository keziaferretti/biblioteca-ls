@extends('layouts.app')

@section('title', 'Empréstimos — Biblioteca LMS')
@section('page-title', 'Empréstimos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">{{ $data->total() }} empréstimo(s) registrado(s)</p>
        <a href="{{ route('loans.create') }}" class="btn btn-primary-accent">
            <i class="bi bi-plus-lg"></i> Novo Empréstimo
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Livro</th>
                        <th>Cliente</th>
                        <th>Empréstimo</th>
                        <th>Devolução prevista</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td>{{ $loan->book?->title ?? '—' }}</td>
                            <td>{{ $loan->customer?->name ?? '—' }}</td>
                            <td>{{ optional($loan->loan_date)->format('d/m/Y') }}</td>
                            <td>{{ optional($loan->due_date)->format('d/m/Y') }}</td>
                            <td><span class="badge badge-status-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-sm btn-outline-primary-accent"><i class="bi bi-pencil"></i></a>
                                @if ($loan->status !== 'returned')
                                    <button type="button" class="btn btn-sm btn-success"
                                            onclick="returnLoan('{{ route('loans.return', $loan->id) }}', '{{ route('loans.index') }}')"
                                            title="Registrar devolução">
                                        <i class="bi bi-arrow-return-left"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmAndDelete('{{ route('loans.destroy', $loan->id) }}', '{{ route('loans.index') }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhum empréstimo registrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $data->links() }}</div>
@endsection
