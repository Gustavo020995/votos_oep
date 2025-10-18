@extends('adminlte::page')

@section('title', 'Editar Mesa')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Mesa de Votación</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('mesas.index') }}" class="btn btn-secondary float-right">
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
                        <h3 class="card-title">Editar Mesa</h3>
                    </div>
                    <form action="{{ route('mesas.update', $mesa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="recinto_id">Recinto *</label>
                                <select class="form-control" id="recinto_id" name="recinto_id" required>
                                    <option value="">Seleccionar Recinto</option>
                                    @foreach($recintos as $recinto)
                                        <option value="{{ $recinto->id }}" 
                                            {{ old('recinto_id', $mesa->recinto_id) == $recinto->id ? 'selected' : '' }}>
                                            {{ $recinto->nombre }} ({{ $recinto->localidad->municipio->provincia->departamento->nombre }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('recinto_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="numero_mesa">Número de Mesa *</label>
                                <input type="text" class="form-control" id="numero_mesa" name="numero_mesa" 
                                       value="{{ old('numero_mesa', $mesa->numero_mesa) }}" required>
                                @error('numero_mesa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="codigo_mesa">Código de Mesa *</label>
                                <input type="text" class="form-control" id="codigo_mesa" name="codigo_mesa" 
                                       value="{{ old('codigo_mesa', $mesa->codigo_mesa) }}" required>
                                @error('codigo_mesa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="total_inscritos">Total de Inscritos *</label>
                                <input type="number" class="form-control" id="total_inscritos" name="total_inscritos" 
                                       value="{{ old('total_inscritos', $mesa->total_inscritos) }}" min="0" required>
                                @error('total_inscritos')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado *</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="pendiente" {{ old('estado', $mesa->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="conteo_en_proceso" {{ old('estado', $mesa->estado) == 'conteo_en_proceso' ? 'selected' : '' }}>Conteo en Proceso</option>
                                    <option value="conteo_finalizado" {{ old('estado', $mesa->estado) == 'conteo_finalizado' ? 'selected' : '' }}>Conteo Finalizado</option>
                                </select>
                                @error('estado')
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