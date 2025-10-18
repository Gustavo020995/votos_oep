@extends('adminlte::page')

@section('title', 'Crear Mesa')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear Mesa de Votación</h1>
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
                        <h3 class="card-title">Información de la Mesa</h3>
                    </div>
                    <form action="{{ route('mesas.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="recinto_id">Recinto *</label>
                                <select class="form-control" id="recinto_id" name="recinto_id" required>
                                    <option value="">Seleccionar Recinto</option>
                                    @foreach($recintos as $recinto)
                                        <option value="{{ $recinto->id }}" {{ old('recinto_id') == $recinto->id ? 'selected' : '' }}>
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
                                       value="{{ old('numero_mesa') }}" required placeholder="Ej: MESA-001">
                                @error('numero_mesa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="codigo_mesa">Código de Mesa *</label>
                                <input type="text" class="form-control" id="codigo_mesa" name="codigo_mesa" 
                                       value="{{ old('codigo_mesa') }}" required placeholder="Ej: LP-P1-M1-L1-R1-ME1">
                                @error('codigo_mesa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="total_inscritos">Total de Inscritos *</label>
                                <input type="number" class="form-control" id="total_inscritos" name="total_inscritos" 
                                       value="{{ old('total_inscritos', 0) }}" min="0" required>
                                @error('total_inscritos')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection