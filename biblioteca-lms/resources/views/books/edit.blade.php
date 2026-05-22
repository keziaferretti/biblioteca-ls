@extends('layouts.app')

@section('title', 'Editar Livro')
@section('page-title', 'Editar Livro')

@section('content')
    <div class="card p-4">
        <form data-json
              data-url="{{ route('books.update', $data->id) }}"
              data-method="PUT"
              data-redirect="{{ route('books.index') }}"
              novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Título *</label>
                    <input type="text" name="title" class="form-control" maxlength="200" value="{{ $data->title }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">ISBN *</label>
                    <input type="text" name="isbn" class="form-control" maxlength="20" value="{{ $data->isbn }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Autor *</label>
                    <input type="text" name="author" class="form-control" maxlength="150" value="{{ $data->author }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Editora *</label>
                    <select name="publisherId" class="form-select" required>
                        @foreach ($publishers as $publisher)
                            <option value="{{ $publisher->id }}" {{ $publisher->id == $data->publisher_id ? 'selected' : '' }}>
                                {{ $publisher->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ano de Publicação *</label>
                    <input type="number" name="publicationYear" class="form-control" min="1500" max="{{ date('Y') }}" value="{{ $data->publication_year }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Total de Exemplares *</label>
                    <input type="number" name="totalCopies" class="form-control" min="1" max="10000" value="{{ $data->total_copies }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Exemplares Disponíveis *</label>
                    <input type="number" name="availableCopies" class="form-control" min="0" value="{{ $data->available_copies }}" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary-accent">Atualizar</button>
            </div>
        </form>
    </div>
@endsection
