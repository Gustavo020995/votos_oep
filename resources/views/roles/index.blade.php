@extends('adminlte::page')

@section('title', 'Roles')

@section('content')
<h1>Lista de Roles</h1>

<a href="{{ route('roles.create') }}" class="btn btn-success mb-3">Crear nuevo rol</a>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Permisos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td>
                {{ $role->permissions->pluck('name')->join(', ') }}
            </td>
            <td>
                <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm">Editar</a>
                <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar rol?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
