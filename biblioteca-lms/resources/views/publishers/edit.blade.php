@extends('layouts.app')

@section('title', 'Editar Editora')
@section('page-title', 'Editar Editora')

@section('content')
    <div class="card p-4">
        <form data-json
              data-url="{{ route('publishers.update', $data->id) }}"
              data-method="PUT"
              data-redirect="{{ route('publishers.index') }}"
              novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome *</label>
                    <input type="text" name="name" class="form-control" maxlength="200" value="{{ $data->name }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail *</label>
                    <input type="email" name="email" class="form-control" maxlength="150" value="{{ $data->email }}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="phone" class="form-control" maxlength="30" value="{{ $data->phone }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control" maxlength="200" value="{{ $data->website }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-12">
                    <label class="form-label">Endereço</label>
                    <input type="text" name="address" class="form-control" maxlength="255" value="{{ $data->address }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('publishers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary-accent">Atualizar</button>
            </div>
        </form>
    </div>
@endsection
