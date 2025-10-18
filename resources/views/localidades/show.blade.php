@extends('adminlte::page')
@section('title', $localidad->nombre)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Localidad: {{ $localidad->nombre }}</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información General</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID:</th>
                                <td>{{ $localidad->id }}</td>
                            </tr>
                            <tr>
                                <th>Nombre:</th>
                                <td>{{ $localidad->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Código:</th>
                                <td>{{ $localidad->codigo }}</td>
                            </tr>
                            <tr>
                                <th>Municipio:</th>
                                <td>{{ $localidad->municipio->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Provincia:</th>
                                <td>{{ $localidad->municipio->provincia->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Departamento:</th>
                                <td>{{ $localidad->municipio->provincia->departamento->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Total Inscritos:</th>
                                <td>{{ number_format($localidad->total_inscritos) }}</td>
                            </tr>
                            <tr>
                                <th>Recintos:</th>
                                <td>{{ $localidad->recintos_count ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th>Mesas:</th>
                                <td>{{ $localidad->total_mesas }}</td>
                            </tr>
                            <tr>
                                <th>% Escrutado:</th>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $localidad->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $localidad->porcentaje_escrutado }}%</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recintos de la Localidad</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Dirección</th>
                                <th>Inscritos</th>
                                <th>Mesas</th>
                                <th>% Escrutado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($localidad->recintos as $recinto)
                            <tr>
                                <td>{{ $recinto->nombre }}</td>
                                <td>{{ $recinto->codigo }}</td>
                                <td>{{ $recinto->direccion ?? 'N/A' }}</td>
                                <td class="text-right">{{ number_format($recinto->total_inscritos) }}</td>
                                <td class="text-center">{{ $recinto->total_mesas }}</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $recinto->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $recinto->porcentaje_escrutado }}%</span>
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