@extends('adminlte::page')

@section('title', 'Editar Roles')

@section('content')
<h1>Editar roles de {{ $user->name }}</h1>

<form action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="roles">Roles</label>
        <select name="roles[]" class="form-control" multiple>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ in_array($role->name, $userRoles) ? 'selected' : '' }}>
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success mt-2">Actualizar Roles</button>
</form>
@endsection
