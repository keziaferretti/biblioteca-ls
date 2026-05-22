@extends('layouts.app')

@section('title', 'Editar Empréstimo')
@section('page-title', 'Editar Empréstimo')

@section('content')
    <div class="card p-4">
        <form data-json
              data-url="{{ route('loans.update', $data->id) }}"
              data-method="PUT"
              data-redirect="{{ route('loans.index') }}"
              novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Livro *</label>
                    <select name="bookId" class="form-select" required>
                        <option value="">Selecione...</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}" {{ $book->id == $data->book_id ? 'selected' : '' }}>
                                {{ $book->title }} ({{ $book->available_copies }} disponível(is))
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cliente *</label>
                    <select name="customerId" class="form-select" required>
                        <option value="">Selecione...</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $data->customer_id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->document }})
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Data do Empréstimo *</label>
                    <input type="date" name="loanDate" class="form-control"
                           value="{{ \Carbon\Carbon::parse($data->loan_date)->format('Y-m-d') }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Devolução Prevista *</label>
                    <input type="date" name="dueDate" class="form-control"
                           value="{{ \Carbon\Carbon::parse($data->due_date)->format('Y-m-d') }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Devolvido em</label>
                    <input type="date" name="returnedAt" class="form-control"
                           value="{{ $data->returned_at ? \Carbon\Carbon::parse($data->returned_at)->format('Y-m-d') : '' }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="active"   {{ $data->status === 'active'   ? 'selected' : '' }}>Ativo</option>
                        <option value="overdue"  {{ $data->status === 'overdue'  ? 'selected' : '' }}>Atrasado</option>
                        <option value="returned" {{ $data->status === 'returned' ? 'selected' : '' }}>Devolvido</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary-accent">Atualizar</button>
            </div>
        </form>
    </div>
@endsection
