@extends('adminlte::page')

@section('title', 'Editar Recinto')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Recinto</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('recintos.index') }}" class="btn btn-secondary float-right">
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
                        <h3 class="card-title">Editar Recinto</h3>
                    </div>
                    <form action="{{ route('recintos.update', $recinto->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="localidad_id">Localidad *</label>
                                <select class="form-control" id="localidad_id" name="localidad_id" required>
                                    <option value="">Seleccionar Localidad</option>
                                    @foreach($localidades as $localidad)
                                        <option value="{{ $localidad->id }}" 
                                            {{ old('localidad_id', $recinto->localidad_id) == $localidad->id ? 'selected' : '' }}>
                                            {{ $localidad->nombre }} ({{ $localidad->municipio->provincia->departamento->nombre }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('localidad_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="{{ old('nombre', $recinto->nombre) }}" required>
                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="codigo">Código *</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" 
                                       value="{{ old('codigo', $recinto->codigo) }}" required>
                                @error('codigo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion">{{ old('direccion', $recinto->direccion) }}</textarea>
                                @error('direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="total_inscritos">Total de Inscritos *</label>
                                <input type="number" class="form-control" id="total_inscritos" name="total_inscritos" 
                                       value="{{ old('total_inscritos', $recinto->total_inscritos) }}" min="0" required>
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