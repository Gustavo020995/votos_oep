@extends('adminlte::page')

@php
    $esEdicion = isset($permission);
    $titulo = $esEdicion ? 'Editar Permiso' : 'Crear Permiso';
@endphp

@section('title', $titulo)

@section('content')
<h1>{{ $titulo }}</h1>

<form method="POST" action="{{ $esEdicion ? route('permissions.update', $permission) : route('permissions.store') }}">
    @csrf
    @if($esEdicion)
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="name">Nombre del permiso</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name ?? '') }}" required>
    </div>

    <button class="btn btn-success mt-2">
        {{ $esEdicion ? 'Actualizar' : 'Crear' }}
    </button>
</form>
@endsection
