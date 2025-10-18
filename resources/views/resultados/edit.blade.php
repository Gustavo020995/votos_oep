@extends('adminlte::page')

@section('title', 'Editar Resultados - Mesa ' . $mesa->numero_mesa)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Resultados - Mesa {{ $mesa->numero_mesa }}</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('resultados.index') }}" class="btn btn-secondary float-right">
                    <i class="fas fa-arrow-left"></i> Volver a Resultados
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
                        <h3 class="card-title">Editar Resultados de la Mesa</h3>
                    </div>
                    <form action="{{ route('resultados.mesa.update', $mesa->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            
                            <!-- Información de la Mesa -->
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Información de la Mesa</h6>
                                <strong>Mesa:</strong> {{ $mesa->numero_mesa }} ({{ $mesa->codigo_mesa }})<br>
                                <strong>Ubicación:</strong> {{ $mesa->ruta_completa }}<br>
                                <strong>Total Inscritos:</strong> {{ number_format($mesa->total_inscritos) }}<br>
                                <strong>Estado:</strong> 
                                <span class="badge badge-{{ $mesa->estado == 'conteo_finalizado' ? 'success' : ($mesa->estado == 'conteo_en_proceso' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst(str_replace('_', ' ', $mesa->estado)) }}
                                </span>
                            </div>

                            <!-- Datos del Acta -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_acta">Número de Acta *</label>
                                        <input type="text" class="form-control" id="numero_acta" name="numero_acta" 
                                               value="{{ old('numero_acta', $actaData->numero_acta ?? '') }}" required>
                                        @error('numero_acta')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_acta">Fecha y Hora del Acta *</label>
                                        <input type="datetime-local" class="form-control" id="fecha_acta" name="fecha_acta" 
                                               value="{{ old('fecha_acta', $actaData->fecha_acta ? $actaData->fecha_acta->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required>
                                        @error('fecha_acta')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Foto del Acta -->
                            <div class="form-group">
                                <label for="foto_acta">Foto del Acta</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto_acta" name="foto_acta" accept="image/*">
                                    <label class="custom-file-label" for="foto_acta">
                                        @if($actaData && $actaData->foto_acta)
                                            Foto actual: {{ basename($actaData->foto_acta) }}
                                        @else
                                            Seleccionar archivo
                                        @endif
                                    </label>
                                </div>
                                @if($actaData && $actaData->foto_acta_url)
                                <small class="form-text text-muted">
                                    <a href="{{ $actaData->foto_acta_url }}" target="_blank">Ver acta actual</a>
                                </small>
                                @endif
                                @error('foto_acta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr>

                            <!-- Votos por Candidato -->
                            <h5>Votos por Candidato</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Candidato</th>
                                            <th>Partido</th>
                                            <th>Votos Actuales</th>
                                            <th>Nuevos Votos</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($candidatos as $candidato)
                                        @php
                                            $votosActuales = $resultadosExistentes[$candidato->id] ?? 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="badge" style="background-color: {{ $candidato->color_hex }}; width: 20px; height: 20px;">&nbsp;</span>
                                                {{ $candidato->nombre }}
                                            </td>
                                            <td>{{ $candidato->partido ?? 'Independiente' }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-info" style="font-size: 1.1em;">{{ $votosActuales }}</span>
                                            </td>
                                            <td style="width: 120px;">
                                                <input type="number" name="votos[{{ $candidato->id }}]" 
                                                       class="form-control votos-input" 
                                                       value="{{ old('votos.' . $candidato->id, $votosActuales) }}" 
                                                       min="0" 
                                                       data-candidato="{{ $candidato->id }}">
                                            </td>
                                            <td style="width: 100px;">
                                                <button type="button" class="btn btn-sm btn-success btn-agregar" data-candidato="{{ $candidato->id }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger btn-quitar" data-candidato="{{ $candidato->id }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Votos Especiales -->
                            <h5>Votos Especiales</h5>
                            <div class="row">
                                @foreach($tiposVotos as $tipo)
                                @php
                                    $cantidadActual = $votosEspecialesExistentes[$tipo->id] ?? 0;
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="votos_especiales_{{ $tipo->id }}">{{ $tipo->nombre }}</label>
                                        <input type="number" class="form-control" id="votos_especiales_{{ $tipo->id }}" 
                                               name="votos_especiales[{{ $tipo->id }}]" 
                                               value="{{ old('votos_especiales.' . $tipo->id, $cantidadActual) }}" 
                                               min="0">
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Resumen -->
                            <div class="alert alert-warning">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4 id="total-votos">0</h4>
                                        <small>Total Votos</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 id="total-inscritos">{{ number_format($mesa->total_inscritos) }}</h4>
                                        <small>Inscritos</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 id="votos-restantes">{{ number_format($mesa->total_inscritos) }}</h4>
                                        <small>Restantes</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btn-submit">
                                <i class="fas fa-save"></i> Actualizar Resultados
                            </button>
                            <a href="{{ route('resultados.index') }}" class="btn btn-secondary">Cancelar</a>
                            
                            @if($mesa->estado != 'conteo_finalizado')
                            <button type="button" class="btn btn-success float-right" onclick="finalizarConteo()">
                                <i class="fas fa-flag-checkered"></i> Finalizar Conteo
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Estadísticas de la Mesa -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Estadísticas de la Mesa</h3>
                    </div>
                    <div class="card-body">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ number_format($mesa->total_votos_emitidos) }}</h3>
                                <p>Votos Emitidos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-vote-yea"></i>
                            </div>
                        </div>

                        <div class="small-box bg-success mt-3">
                            <div class="inner">
                                <h3>{{ $mesa->porcentaje_participacion }}%</h3>
                                <p>Participación</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>

                        <div class="small-box bg-warning mt-3">
                            <div class="inner">
                                <h3>{{ number_format($mesa->total_inscritos - $mesa->total_votos_emitidos) }}</h3>
                                <p>Abstenciones</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-slash"></i>
                            </div>
                        </div>

                        <hr>

                        <h5>Distribución Actual</h5>
                        <div class="progress-group">
                            Votos Válidos
                            <span class="float-right"><b>{{ number_format($mesa->total_votos) }}</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{ $mesa->total_inscritos > 0 ? ($mesa->total_votos / $mesa->total_inscritos) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            Votos Especiales
                            <span class="float-right"><b>{{ number_format($mesa->total_votos_especiales) }}</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: {{ $mesa->total_inscritos > 0 ? ($mesa->total_votos_especiales / $mesa->total_inscritos) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de ayuda -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Instrucciones</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Para actualizar resultados:</strong></p>
                        <ol>
                            <li>Verifique el número y fecha del acta</li>
                            <li>Actualice los votos por candidato</li>
                            <li>Complete los votos especiales</li>
                            <li>Verifique que el total no exceda los inscritos</li>
                            <li>Guarde los cambios</li>
                        </ol>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Importante:</strong> El total de votos no puede exceder el número de ciudadanos inscritos en la mesa.
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
    const totalInscritos = {{ $mesa->total_inscritos }};

    // Botones para agregar/quitar votos
    document.querySelectorAll('.btn-agregar').forEach(btn => {
        btn.addEventListener('click', function() {
            const candidatoId = this.getAttribute('data-candidato');
            const input = document.querySelector(`input[data-candidato="${candidatoId}"]`);
            input.value = parseInt(input.value) + 1;
            calcularTotales();
        });
    });

    document.querySelectorAll('.btn-quitar').forEach(btn => {
        btn.addEventListener('click', function() {
            const candidatoId = this.getAttribute('data-candidato');
            const input = document.querySelector(`input[data-candidato="${candidatoId}"]`);
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                calcularTotales();
            }
        });
    });

    // Calcular totales
    function calcularTotales() {
        let totalVotos = 0;
        
        // Sumar votos de candidatos
        document.querySelectorAll('.votos-input').forEach(input => {
            totalVotos += parseInt(input.value) || 0;
        });

        // Sumar votos especiales
        document.querySelectorAll('input[name^="votos_especiales"]').forEach(input => {
            totalVotos += parseInt(input.value) || 0;
        });

        const votosRestantes = totalInscritos - totalVotos;

        document.getElementById('total-votos').textContent = totalVotos.toLocaleString();
        document.getElementById('votos-restantes').textContent = votosRestantes.toLocaleString();

        // Validar
        const btnSubmit = document.getElementById('btn-submit');
        if (totalVotos > totalInscritos) {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('btn-danger');
            btnSubmit.classList.remove('btn-primary');
        } else {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('btn-danger');
            btnSubmit.classList.add('btn-primary');
        }
    }

    // Calcular totales cuando cambien los inputs
    document.querySelectorAll('.votos-input, input[name^="votos_especiales"]').forEach(input => {
        input.addEventListener('input', calcularTotales);
    });

    // Preview del nombre del archivo
    document.querySelector('.custom-file-input').addEventListener('change', function() {
        let fileName = this.value.split('\\').pop();
        this.nextElementSibling.textContent = fileName;
    });

    // Inicializar cálculos
    calcularTotales();
});

function finalizarConteo() {
    if (confirm('¿Está seguro de finalizar el conteo de esta mesa? Esta acción no se puede deshacer.')) {
        // Aquí podrías implementar la lógica para finalizar el conteo
        alert('Conteo finalizado para la mesa {{ $mesa->numero_mesa }}');
    }
}
</script>
@endsection