@extends('adminlte::page')

@section('title', $departamento->nombre)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Departamento: {{ $departamento->nombre }}</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('departamentos.index') }}" class="btn btn-secondary float-right">
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
                                <td>{{ $departamento->id }}</td>
                            </tr>
                            <tr>
                                <th>Nombre:</th>
                                <td>{{ $departamento->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Código:</th>
                                <td>{{ $departamento->codigo }}</td>
                            </tr>
                            <tr>
                                <th>Total Inscritos:</th>
                                <td>{{ number_format($departamento->total_inscritos) }}</td>
                            </tr>
                            <tr>
                                <th>Provincias:</th>
                                <td>{{ $departamento->provincias_count ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th>Mesas:</th>
                                <td>{{ $departamento->total_mesas }}</td>
                            </tr>
                            <tr>
                                <th>% Escrutado:</th>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $departamento->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $departamento->porcentaje_escrutado }}%</span>
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
                                <h3>{{ number_format($departamento->total_votos_validos) }}</h3>
                                <p>Votos Válidos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-vote-yea"></i>
                            </div>
                        </div>
                        <div class="small-box bg-success mt-3">
                            <div class="inner">
                                <h3>{{ $departamento->participacion }}%</h3>
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Provincias del Departamento</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Inscritos</th>
                                <th>Municipios</th>
                                <th>Mesas</th>
                                <th>% Escrutado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departamento->provincias as $provincia)
                            <tr>
                                <td>{{ $provincia->nombre }}</td>
                                <td>{{ $provincia->codigo }}</td>
                                <td class="text-right">{{ number_format($provincia->total_inscritos) }}</td>
                                <td class="text-center">{{ $provincia->municipios_count ?? 0 }}</td>
                                <td class="text-center">{{ $provincia->total_mesas }}</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $provincia->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $provincia->porcentaje_escrutado }}%</span>
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