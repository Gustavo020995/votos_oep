@extends('adminlte::page')

@section('title', $mesa->numero_mesa)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Mesa: {{ $mesa->numero_mesa }}</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información General</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID:</th>
                                <td>{{ $mesa->id }}</td>
                            </tr>
                            <tr>
                                <th>Número Mesa:</th>
                                <td>{{ $mesa->numero_mesa }}</td>
                            </tr>
                            <tr>
                                <th>Código:</th>
                                <td>{{ $mesa->codigo_mesa }}</td>
                            </tr>
                            <tr>
                                <th>Recinto:</th>
                                <td>{{ $mesa->recinto->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Localidad:</th>
                                <td>{{ $mesa->recinto->localidad->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Municipio:</th>
                                <td>{{ $mesa->recinto->localidad->municipio->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Provincia:</th>
                                <td>{{ $mesa->recinto->localidad->municipio->provincia->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Departamento:</th>
                                <td>{{ $mesa->recinto->localidad->municipio->provincia->departamento->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Total Inscritos:</th>
                                <td>{{ number_format($mesa->total_inscritos) }}</td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>
                                    <span class="badge badge-{{ $mesa->estado == 'conteo_finalizado' ? 'success' : ($mesa->estado == 'conteo_en_proceso' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $mesa->estado)) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estadísticas</h3>
                    </div>
                    <div class="card-body">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ number_format($mesa->total_votos) }}</h3>
                                <p>Votos Válidos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-vote-yea"></i>
                            </div>
                        </div>
                        <div class="small-box bg-success mt-3">
                            <div class="inner">
                                <h3>{{ number_format($mesa->total_votos_especiales) }}</h3>
                                <p>Votos Especiales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                        <div class="small-box bg-warning mt-3">
                            <div class="inner">
                                <h3>{{ $mesa->porcentaje_participacion }}%</h3>
                                <p>Participación</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($mesa->resultados->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Resultados por Candidato</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Candidato</th>
                                <th>Partido</th>
                                <th>Votos</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mesa->resultados as $resultado)
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: {{ $resultado->candidato->color_hex }}; width: 20px; height: 20px;">&nbsp;</span>
                                    {{ $resultado->candidato->nombre }}
                                </td>
                                <td>{{ $resultado->candidato->partido ?? 'Independiente' }}</td>
                                <td class="text-right">{{ number_format($resultado->votos) }}</td>
                                <td class="text-right">
                                    {{ $mesa->total_votos > 0 ? round(($resultado->votos / $mesa->total_votos) * 100, 2) : 0 }}%
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if($mesa->votosEspeciales->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Votos Especiales</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tipo de Voto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mesa->votosEspeciales as $votoEspecial)
                            <tr>
                                <td>{{ $votoEspecial->tipoVoto->nombre }}</td>
                                <td class="text-right">{{ number_format($votoEspecial->cantidad) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-footer">
                <a href="{{ route('resultados.mesa.edit', $mesa->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Resultados
                </a>
                <a href="{{ route('resultados.create') }}?mesa_id={{ $mesa->id }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Registrar Nueva Acta
                </a>
            </div>
        </div>
    </div>
</section>
@endsection