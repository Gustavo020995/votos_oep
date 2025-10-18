@extends('adminlte::page')

@section('title', $candidato->nombre)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Candidato: {{ $candidato->nombre }}</h1>
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información del Candidato</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $candidato->foto_url }}" alt="{{ $candidato->nombre }}" class="img-fluid rounded mb-3" style="max-height: 250px;">
                        
                        <div class="p-3 rounded mb-3" style="background-color: {{ $candidato->color_hex }}; color: {{ $candidato->color_hex == '#000000' ? '#fff' : '#000' }};">
                            <h4>{{ $candidato->nombre }}</h4>
                            @if($candidato->partido)
                            <p class="mb-0">{{ $candidato->partido }}</p>
                            @endif
                        </div>

                        <table class="table table-bordered">
                            <tr>
                                <th>Estado:</th>
                                <td>
                                    <span class="badge badge-{{ $candidato->activo ? 'success' : 'danger' }}">
                                        {{ $candidato->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Votos:</th>
                                <td class="text-right">
                                    <strong>{{ number_format($candidato->total_votos) }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Porcentaje:</th>
                                <td class="text-right">
                                    <strong>{{ $candidato->porcentaje_votos }}%</strong>
                                </td>
                            </tr>
                        </table>

                        @if($candidato->propuesta)
                        <div class="mt-3 text-left">
                            <h5>Propuesta:</h5>
                            <p>{{ $candidato->propuesta }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Distribución de Votos por Departamento</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Departamento</th>
                                        <th>Votos</th>
                                        <th>Porcentaje</th>
                                        <th>Progreso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $votosPorDepartamento = [];
                                        foreach($candidato->resultados as $resultado) {
                                            $departamentoNombre = $resultado->mesa->recinto->localidad->municipio->provincia->departamento->nombre;
                                            if (!isset($votosPorDepartamento[$departamentoNombre])) {
                                                $votosPorDepartamento[$departamentoNombre] = 0;
                                            }
                                            $votosPorDepartamento[$departamentoNombre] += $resultado->votos;
                                        }
                                    @endphp
                                    @foreach($votosPorDepartamento as $departamento => $votos)
                                    <tr>
                                        <td>{{ $departamento }}</td>
                                        <td class="text-right">{{ number_format($votos) }}</td>
                                        <td class="text-right">
                                            {{ $candidato->total_votos > 0 ? round(($votos / $candidato->total_votos) * 100, 2) : 0 }}%
                                        </td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar" style="width: {{ $candidato->total_votos > 0 ? ($votos / $candidato->total_votos) * 100 : 0 }}%; background-color: {{ $candidato->color_hex }}"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Últimos Resultados Registrados</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Mesa</th>
                                        <th>Ubicación</th>
                                        <th>Votos</th>
                                        <th>Fecha Acta</th>
                                        <th>Estado Acta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidato->resultados->take(10) as $resultado)
                                    <tr>
                                        <td>
                                            <strong>{{ $resultado->mesa->numero_mesa }}</strong>
                                            <br><small class="text-muted">{{ $resultado->mesa->codigo_mesa }}</small>
                                        </td>
                                        <td>
                                            <small>
                                                {{ $resultado->mesa->recinto->localidad->municipio->nombre }} → 
                                                {{ $resultado->mesa->recinto->localidad->nombre }}
                                            </small>
                                        </td>
                                        <td class="text-right">
                                            <strong>{{ number_format($resultado->votos) }}</strong>
                                        </td>
                                        <td>
                                            {{ $resultado->fecha_acta ? $resultado->fecha_acta->format('d/m/Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $resultado->estado_acta_color }}">
                                                {{ ucfirst($resultado->estado_acta) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection