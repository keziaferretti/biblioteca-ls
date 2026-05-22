@extends('layouts.app')

@section('title', 'Novo Cliente')
@section('page-title', 'Novo Cliente')

@section('content')
    <div class="card p-4">
        <form data-json
              data-url="{{ route('customers.store') }}"
              data-method="POST"
              data-redirect="{{ route('customers.index') }}"
              novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Nome *</label>
                    <input type="text" name="name" class="form-control" maxlength="150" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">CPF *</label>
                    <input type="text" name="document" class="form-control" maxlength="14" required placeholder="Apenas números">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail *</label>
                    <input type="email" name="email" class="form-control" maxlength="150" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="phone" class="form-control" maxlength="30">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Data de Nascimento</label>
                    <input type="date" name="birthDate" class="form-control" max="{{ date('Y-m-d') }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Endereço</label>
                    <input type="text" name="address" class="form-control" maxlength="255">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary-accent">Salvar</button>
            </div>
        </form>
    </div>
@endsection
