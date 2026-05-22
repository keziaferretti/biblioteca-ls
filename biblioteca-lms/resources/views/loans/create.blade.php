@extends('layouts.app')

@section('title', 'Novo Empréstimo')
@section('page-title', 'Novo Empréstimo')

@section('content')
    <div class="card p-4">
        <form data-json
              data-url="{{ route('loans.store') }}"
              data-method="POST"
              data-redirect="{{ route('loans.index') }}"
              novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Livro *</label>
                    <select name="bookId" class="form-select" required>
                        <option value="">Selecione...</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">
                                {{ $book->title }} ({{ $book->available_copies }} disponível(is))
                            </option>
                        @endforeach
                    </select>
                    @if ($books->isEmpty())
                        <small class="text-danger">Nenhum livro com exemplares disponíveis no momento.</small>
                    @endif
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cliente *</label>
                    <select name="customerId" class="form-select" required>
                        <option value="">Selecione...</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->document }})</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Data do Empréstimo *</label>
                    <input type="date" name="loanDate" class="form-control" value="{{ date('Y-m-d') }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Devolução Prevista *</label>
                    <input type="date" name="dueDate" class="form-control" value="{{ date('Y-m-d', strtotime('+14 days')) }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="active" selected>Ativo</option>
                        <option value="overdue">Atrasado</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary-accent">Registrar</button>
            </div>
        </form>
    </div>
@endsection
