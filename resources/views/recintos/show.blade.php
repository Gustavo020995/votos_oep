@extends('adminlte::page')

@section('title', $recinto->nombre)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Recinto: {{ $recinto->nombre }}</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información General</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID:</th>
                                <td>{{ $recinto->id }}</td>
                            </tr>
                            <tr>
                                <th>Nombre:</th>
                                <td>{{ $recinto->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Código:</th>
                                <td>{{ $recinto->codigo }}</td>
                            </tr>
                            <tr>
                                <th>Dirección:</th>
                                <td>{{ $recinto->direccion ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Localidad:</th>
                                <td>{{ $recinto->localidad->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Municipio:</th>
                                <td>{{ $recinto->localidad->municipio->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Provincia:</th>
                                <td>{{ $recinto->localidad->municipio->provincia->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Departamento:</th>
                                <td>{{ $recinto->localidad->municipio->provincia->departamento->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Total Inscritos:</th>
                                <td>{{ number_format($recinto->total_inscritos) }}</td>
                            </tr>
                            <tr>
                                <th>Mesas:</th>
                                <td>{{ $recinto->total_mesas }}</td>
                            </tr>
                            <tr>
                                <th>% Escrutado:</th>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $recinto->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $recinto->porcentaje_escrutado }}%</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mesas del Recinto</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Número Mesa</th>
                                <th>Código</th>
                                <th>Inscritos</th>
                                <th>Votos Emitidos</th>
                                <th>Participación</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recinto->mesas as $mesa)
                            <tr>
                                <td>{{ $mesa->numero_mesa }}</td>
                                <td>{{ $mesa->codigo_mesa }}</td>
                                <td class="text-right">{{ number_format($mesa->total_inscritos) }}</td>
                                <td class="text-right">{{ number_format($mesa->total_votos_emitidos) }}</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $mesa->porcentaje_participacion }}%"></div>
                                    </div>
                                    <span>{{ $mesa->porcentaje_participacion }}%</span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $mesa->estado == 'conteo_finalizado' ? 'success' : ($mesa->estado == 'conteo_en_proceso' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $mesa->estado)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('mesas.show', $mesa->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('resultados.mesa.edit', $mesa->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-clipboard-list"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection