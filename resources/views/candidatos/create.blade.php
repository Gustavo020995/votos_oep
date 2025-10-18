@extends('adminlte::page')

@section('title', 'Crear Candidato')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear Candidato</h1>
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
                        <h3 class="card-title">Información del Candidato</h3>
                    </div>
                    <form action="{{ route('candidatos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Completo *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                               value="{{ old('nombre') }}" required placeholder="Ingrese el nombre del candidato">
                                        @error('nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="partido">Partido Político</label>
                                        <input type="text" class="form-control" id="partido" name="partido" 
                                               value="{{ old('partido') }}" placeholder="Ingrese el partido político">
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
                                               value="{{ old('color_hex', '#3498db') }}" required>
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
                                        @error('foto')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="propuesta">Propuesta o Descripción</label>
                                <textarea class="form-control" id="propuesta" name="propuesta" rows="4" 
                                          placeholder="Ingrese la propuesta o descripción del candidato">{{ old('propuesta') }}</textarea>
                                @error('propuesta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="activo" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                                    <label for="activo" class="custom-control-label">Candidato Activo</label>
                                </div>
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

            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Vista Previa</h3>
                    </div>
                    <div class="card-body text-center">
                        <div id="foto-preview" class="mb-3">
                            <img src="{{ asset('img/default-candidate.jpg') }}" alt="Vista previa" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                        <div id="color-preview" class="p-3 rounded">
                            <strong id="nombre-preview">Nombre del Candidato</strong>
                            <br>
                            <span id="partido-preview" class="text-muted">Partido Político</span>
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
        document.getElementById('nombre-preview').textContent = this.value || 'Nombre del Candidato';
    });

    document.getElementById('partido').addEventListener('input', function() {
        document.getElementById('partido-preview').textContent = this.value || 'Partido Político';
    });

    // Inicializar preview
    document.getElementById('color_hex').dispatchEvent(new Event('input'));
});
</script>
@endsection