@extends('adminlte::page')

@section('title', 'Editar Candidato')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Candidato</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('candidatos.index') }}" class="btn btn-secondary float-right">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Editar Candidato</h3>
                    </div>
                    <form action="{{ route('candidatos.update', $candidato->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Completo *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                               value="{{ old('nombre', $candidato->nombre) }}" required>
                                        @error('nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="partido">Partido Político</label>
                                        <input type="text" class="form-control" id="partido" name="partido" 
                                               value="{{ old('partido', $candidato->partido) }}">
                                        @error('partido')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color_hex">Color de Identificación *</label>
                                        <input type="color" class="form-control" id="color_hex" name="color_hex" 
                                               value="{{ old('color_hex', $candidato->color_hex) }}" required>
                                        @error('color_hex')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto">Foto del Candidato</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                                            <label class="custom-file-label" for="foto">Seleccionar archivo</label>
                                        </div>
                                        @if($candidato->foto)
                                        <small class="form-text text-muted">
                                            Foto actual: <a href="{{ $candidato->foto_url }}" target="_blank">Ver foto</a>
                                        </small>
                                        @endif
                                        @error('foto')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="propuesta">Propuesta o Descripción</label>
                                <textarea class="form-control" id="propuesta" name="propuesta" rows="4">{{ old('propuesta', $candidato->propuesta) }}</textarea>
                                @error('propuesta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="activo" name="activo" value="1" 
                                           {{ old('activo', $candidato->activo) ? 'checked' : '' }}>
                                    <label for="activo" class="custom-control-label">Candidato Activo</label>
                                </div>
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

            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Vista Previa</h3>
                    </div>
                    <div class="card-body text-center">
                        <div id="foto-preview" class="mb-3">
                            <img src="{{ $candidato->foto_url }}" alt="Vista previa" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                        <div id="color-preview" class="p-3 rounded" style="background-color: {{ $candidato->color_hex }}; color: {{ $candidato->color_hex == '#000000' ? '#fff' : '#000' }};">
                            <strong id="nombre-preview">{{ $candidato->nombre }}</strong>
                            <br>
                            <span id="partido-preview" class="text-muted">{{ $candidato->partido ?? 'Partido Político' }}</span>
                        </div>
                        
                        <div class="mt-3">
                            <h5>Estadísticas</h5>
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ number_format($candidato->total_votos) }}</h3>
                                    <p>Total Votos</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-vote-yea"></i>
                                </div>
                            </div>
                            <div class="small-box bg-info mt-2">
                                <div class="inner">
                                    <h3>{{ $candidato->porcentaje_votos }}%</h3>
                                    <p>Porcentaje</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview de la foto
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('foto-preview').innerHTML = 
                    `<img src="${e.target.result}" alt="Vista previa" class="img-fluid rounded" style="max-height: 200px;">`;
            }
            reader.readAsDataURL(file);
            document.querySelector('.custom-file-label').textContent = file.name;
        }
    });

    // Preview del color y nombre
    document.getElementById('color_hex').addEventListener('input', function() {
        const color = this.value;
        document.getElementById('color-preview').style.backgroundColor = color;
        
        // Calcular color de texto contrastante
        const hex = color.replace('#', '');
        const r = parseInt(hex.substr(0,2), 16);
        const g = parseInt(hex.substr(2,2), 16);
        const b = parseInt(hex.substr(4,2), 16);
        const brightness = ((r * 299) + (g * 587) + (b * 114)) / 1000;
        document.getElementById('color-preview').style.color = brightness > 128 ? '#000' : '#fff';
    });

    // Preview del nombre y partido
    document.getElementById('nombre').addEventListener('input', function() {
        document.getElementById('nombre-preview').textContent = this.value;
    });

    document.getElementById('partido').addEventListener('input', function() {
        document.getElementById('partido-preview').textContent = this.value || 'Partido Político';
    });
});
</script>
@endsection