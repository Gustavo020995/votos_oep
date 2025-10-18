@extends('adminlte::page')

@section('title', $provincia->nombre)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Provincia: {{ $provincia->nombre }}</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('provincias.index') }}" class="btn btn-secondary float-right">
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
                                <td>{{ $provincia->id }}</td>
                            </tr>
                            <tr>
                                <th>Nombre:</th>
                                <td>{{ $provincia->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Código:</th>
                                <td>{{ $provincia->codigo }}</td>
                            </tr>
                            <tr>
                                <th>Departamento:</th>
                                <td>{{ $provincia->departamento->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Total Inscritos:</th>
                                <td>{{ number_format($provincia->total_inscritos) }}</td>
                            </tr>
                            <tr>
                                <th>Municipios:</th>
                                <td>{{ $provincia->municipios_count ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th>Mesas:</th>
                                <td>{{ $provincia->total_mesas }}</td>
                            </tr>
                            <tr>
                                <th>% Escrutado:</th>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $provincia->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $provincia->porcentaje_escrutado }}%</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Municipios de la Provincia</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Inscritos</th>
                                <th>Localidades</th>
                                <th>Mesas</th>
                                <th>% Escrutado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($provincia->municipios as $municipio)
                            <tr>
                                <td>{{ $municipio->nombre }}</td>
                                <td>{{ $municipio->codigo }}</td>
                                <td class="text-right">{{ number_format($municipio->total_inscritos) }}</td>
                                <td class="text-center">{{ $municipio->localidades_count ?? 0 }}</td>
                                <td class="text-center">{{ $municipio->total_mesas }}</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $municipio->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $municipio->porcentaje_escrutado }}%</span>
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