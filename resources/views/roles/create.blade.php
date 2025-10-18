@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content')
<h1>Crear Rol</h1>

<form method="POST" action="{{ route('roles.store') }}">
    @csrf

    <div class="form-group">
        <label for="name">Nombre del rol</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
        <label for="permissions">Permisos</label><br>
        @foreach($permissions as $permission)
            <label>
                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                {{ $permission->name }}
            </label><br>
        @endforeach
    </div>

    <button class="btn btn-success mt-2">Guardar</button>
</form>
@endsection
