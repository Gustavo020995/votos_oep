@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
<h1>Usuarios</h1>

<a href="{{ route('users.create') }}" class="btn btn-success mb-2">Crear usuario</a>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->getRoleNames()->first() }}</td>
            <td>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">Editar rol</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
