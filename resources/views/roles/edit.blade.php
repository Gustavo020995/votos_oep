@extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content')
<h1>Editar Rol</h1>

<form method="POST" action="{{ route('roles.update', $role) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Nombre del rol</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
    </div>

    <div class="form-group">
        <label for="permissions">Permisos</label><br>
        @foreach($permissions as $permission)
            <label>
                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                    {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                {{ $permission->name }}
            </label><br>
        @endforeach
    </div>

    <button class="btn btn-primary mt-2">Actualizar</button>
</form>
@endsection
