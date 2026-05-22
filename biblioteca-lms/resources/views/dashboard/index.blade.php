@extends('layouts.app')

@section('title', 'Dashboard — Biblioteca LMS')
@section('page-title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total de Livros</div>
                        <div class="stat-value">{{ $totalBooks }}</div>
                    </div>
                    <i class="bi bi-journal-bookmark stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Empréstimos Ativos</div>
                        <div class="stat-value">{{ $activeLoansCount }}</div>
                    </div>
                    <i class="bi bi-arrow-left-right stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Clientes Cadastrados</div>
                        <div class="stat-value">{{ $totalCustomers }}</div>
                    </div>
                    <i class="bi bi-people stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Livros Atrasados</div>
                        <div class="stat-value text-danger">{{ $overdueLoansCount }}</div>
                    </div>
                    <i class="bi bi-exclamation-triangle stat-icon text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Empréstimos Recentes</h5>
            <a href="{{ route('loans.index') }}" class="btn btn-sm btn-outline-primary-accent">Ver todos</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Livro</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentLoans as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td>{{ $loan->book?->title ?? '—' }}</td>
                            <td>{{ $loan->customer?->name ?? '—' }}</td>
                            <td>{{ optional($loan->loan_date)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-status-{{ $loan->status }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhum empréstimo registrado ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
