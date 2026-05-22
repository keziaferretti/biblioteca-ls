@extends('layouts.app')

@section('title', 'Novo Livro')
@section('page-title', 'Novo Livro')

@section('content')
    <div class="card p-4">
        <form data-json
              data-url="{{ route('books.store') }}"
              data-method="POST"
              data-redirect="{{ route('books.index') }}"
              novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Título *</label>
                    <input type="text" name="title" class="form-control" maxlength="200" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">ISBN *</label>
                    <input type="text" name="isbn" class="form-control" maxlength="20" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Autor *</label>
                    <input type="text" name="author" class="form-control" maxlength="150" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Editora *</label>
                    <select name="publisherId" class="form-select" required>
                        <option value="">Selecione...</option>
                        @foreach ($publishers as $publisher)
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ano de Publicação *</label>
                    <input type="number" name="publicationYear" class="form-control" min="1500" max="{{ date('Y') }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Total de Exemplares *</label>
                    <input type="number" name="totalCopies" class="form-control" min="1" max="10000" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Exemplares Disponíveis *</label>
                    <input type="number" name="availableCopies" class="form-control" min="0" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary-accent">Salvar</button>
            </div>
        </form>
    </div>
@endsection
