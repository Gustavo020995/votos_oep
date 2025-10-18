@extends('adminlte::page')

@section('title', 'Permisos')

@section('content')
<h1>Lista de Permisos</h1>

<a href="{{ route('permissions.create') }}" class="btn btn-success mb-3">Crear nuevo permiso</a>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->name }}</td>
            <td>
                <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary btn-sm">Editar</a>
                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este permiso?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
