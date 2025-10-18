@extends('adminlte::page')

@section('title', $municipio->nombre)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Municipio: {{ $municipio->nombre }}</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('municipios.index') }}" class="btn btn-secondary float-right">
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
                                <td>{{ $municipio->id }}</td>
                            </tr>
                            <tr>
                                <th>Nombre:</th>
                                <td>{{ $municipio->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Código:</th>
                                <td>{{ $municipio->codigo }}</td>
                            </tr>
                            <tr>
                                <th>Provincia:</th>
                                <td>{{ $municipio->provincia->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Departamento:</th>
                                <td>{{ $municipio->provincia->departamento->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Total Inscritos:</th>
                                <td>{{ number_format($municipio->total_inscritos) }}</td>
                            </tr>
                            <tr>
                                <th>Localidades:</th>
                                <td>{{ $municipio->localidades_count ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th>Mesas:</th>
                                <td>{{ $municipio->total_mesas }}</td>
                            </tr>
                            <tr>
                                <th>% Escrutado:</th>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $municipio->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $municipio->porcentaje_escrutado }}%</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Localidades del Municipio</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Inscritos</th>
                                <th>Recintos</th>
                                <th>Mesas</th>
                                <th>% Escrutado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($municipio->localidades as $localidad)
                            <tr>
                                <td>{{ $localidad->nombre }}</td>
                                <td>{{ $localidad->codigo }}</td>
                                <td class="text-right">{{ number_format($localidad->total_inscritos) }}</td>
                                <td class="text-center">{{ $localidad->recintos_count ?? 0 }}</td>
                                <td class="text-center">{{ $localidad->total_mesas }}</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $localidad->porcentaje_escrutado }}%"></div>
                                    </div>
                                    <span>{{ $localidad->porcentaje_escrutado }}%</span>
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