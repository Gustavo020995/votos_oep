@extends('adminlte::page')

@section('title', 'Localidades')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Gestión de Localidades</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('localidades.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Nueva Localidad
        </a>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Municipio</th>
                <th>Provincia</th>
                <th>Departamento</th>
                <th>Total Inscritos</th>
                <th>Recintos</th>
                <th>Mesas</th>
                <th>% Escrutado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($localidades as $localidad)
              <tr>
                <td>{{ $localidad->id }}</td>
                <td>
                  <strong>{{ $localidad->nombre }}</strong>
                </td>
                <td>{{ $localidad->codigo }}</td>
                <td>{{ $localidad->municipio->nombre }}</td>
                <td>{{ $localidad->municipio->provincia->nombre }}</td>
                <td>{{ $localidad->municipio->provincia->departamento->nombre }}</td>
                <td class="text-right">{{ number_format($localidad->total_inscritos) }}</td>
                <td class="text-center">{{ $localidad->recintos_count ?? 0 }}</td>
                <td class="text-center">{{ $localidad->total_mesas }}</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-{{ $localidad->porcentaje_escrutado >= 80 ? 'success' : ($localidad->porcentaje_escrutado >= 50 ? 'warning' : 'danger') }}" 
                         style="width: {{ $localidad->porcentaje_escrutado }}%"></div>
                  </div>
                  <small class="text-muted">{{ $localidad->porcentaje_escrutado }}%</small>
                </td>
                <td>
                  <a href="{{ route('localidades.edit', $localidad->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('localidades.show', $localidad->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
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