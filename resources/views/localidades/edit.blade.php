@extends('adminlte::page')

@section('title', 'Editar Localidad')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Localidad</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('localidades.index') }}" class="btn btn-secondary float-right">
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
                        <h3 class="card-title">Editar Localidad</h3>
                    </div>
                    <form action="{{ route('localidades.update', $localidad->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="municipio_id">Municipio *</label>
                                <select class="form-control" id="municipio_id" name="municipio_id" required>
                                    <option value="">Seleccionar Municipio</option>
                                    @foreach($municipios as $municipio)
                                        <option value="{{ $municipio->id }}" 
                                            {{ old('municipio_id', $localidad->municipio_id) == $municipio->id ? 'selected' : '' }}>
                                            {{ $municipio->nombre }} ({{ $municipio->provincia->departamento->nombre }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('municipio_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="{{ old('nombre', $localidad->nombre) }}" required>
                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="codigo">Código *</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" 
                                       value="{{ old('codigo', $localidad->codigo) }}" required>
                                @error('codigo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="total_inscritos">Total de Inscritos *</label>
                                <input type="number" class="form-control" id="total_inscritos" name="total_inscritos" 
                                       value="{{ old('total_inscritos', $localidad->total_inscritos) }}" min="0" required>
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