@extends('adminlte::page')
@section('title', 'Editar Provincia')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Provincia</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('provincias.index') }}" class="btn btn-secondary float-right">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Editar Provincia</h3>
                    </div>
                    <form action="{{ route('provincias.update', $provincia->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="departamento_id">Departamento *</label>
                                <select class="form-control" id="departamento_id" name="departamento_id" required>
                                    <option value="">Seleccionar Departamento</option>
                                    @foreach($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}" 
                                            {{ old('departamento_id', $provincia->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                            {{ $departamento->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('departamento_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="{{ old('nombre', $provincia->nombre) }}" required>
                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="codigo">Código *</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" 
                                       value="{{ old('codigo', $provincia->codigo) }}" required>
                                @error('codigo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="total_inscritos">Total de Inscritos *</label>
                                <input type="number" class="form-control" id="total_inscritos" name="total_inscritos" 
                                       value="{{ old('total_inscritos', $provincia->total_inscritos) }}" min="0" required>
                                @error('total_inscritos')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection