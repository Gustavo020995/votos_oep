@extends('adminlte::page')
@section('title', 'Provincias')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Gestión de Provincias</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('provincias.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Nueva Provincia
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
                <th>Departamento</th>
                <th>Total Inscritos</th>
                <th>Municipios</th>
                <th>Mesas</th>
                <th>% Escrutado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($provincias as $provincia)
              <tr>
                <td>{{ $provincia->id }}</td>
                <td>
                  <strong>{{ $provincia->nombre }}</strong>
                </td>
                <td>{{ $provincia->codigo }}</td>
                <td>{{ $provincia->departamento->nombre }}</td>
                <td class="text-right">{{ number_format($provincia->total_inscritos) }}</td>
                <td class="text-center">{{ $provincia->municipios_count ?? 0 }}</td>
                <td class="text-center">{{ $provincia->total_mesas }}</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-{{ $provincia->porcentaje_escrutado >= 80 ? 'success' : ($provincia->porcentaje_escrutado >= 50 ? 'warning' : 'danger') }}" 
                         style="width: {{ $provincia->porcentaje_escrutado }}%"></div>
                  </div>
                  <small class="text-muted">{{ $provincia->porcentaje_escrutado }}%</small>
                </td>
                <td>
                  <a href="{{ route('provincias.edit', $provincia->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('provincias.show', $provincia->id) }}" class="btn btn-info btn-sm">
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