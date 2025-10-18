@extends('adminlte::page')

@section('title', 'Municipios')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Gestión de Municipios</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('municipios.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Nuevo Municipio
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
                <th>Provincia</th>
                <th>Departamento</th>
                <th>Total Inscritos</th>
                <th>Localidades</th>
                <th>Mesas</th>
                <th>% Escrutado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($municipios as $municipio)
              <tr>
                <td>{{ $municipio->id }}</td>
                <td>
                  <strong>{{ $municipio->nombre }}</strong>
                </td>
                <td>{{ $municipio->codigo }}</td>
                <td>{{ $municipio->provincia->nombre }}</td>
                <td>{{ $municipio->provincia->departamento->nombre }}</td>
                <td class="text-right">{{ number_format($municipio->total_inscritos) }}</td>
                <td class="text-center">{{ $municipio->localidades_count ?? 0 }}</td>
                <td class="text-center">{{ $municipio->total_mesas }}</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-{{ $municipio->porcentaje_escrutado >= 80 ? 'success' : ($municipio->porcentaje_escrutado >= 50 ? 'warning' : 'danger') }}" 
                         style="width: {{ $municipio->porcentaje_escrutado }}%"></div>
                  </div>
                  <small class="text-muted">{{ $municipio->porcentaje_escrutado }}%</small>
                </td>
                <td>
                  <a href="{{ route('municipios.edit', $municipio->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('municipios.show', $municipio->id) }}" class="btn btn-info btn-sm">
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