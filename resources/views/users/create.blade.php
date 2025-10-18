@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content')
<h1>Crear nuevo usuario</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Roles</label>
        <select name="roles[]" class="form-control" multiple>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success mt-2">Crear Usuario</button>
</form>
@endsection
