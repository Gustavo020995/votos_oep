@extends('adminlte::page')

@section('title', 'Departamentos')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Gestión de Departamentos</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('departamentos.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Nuevo Departamento
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
                <th>Total Inscritos</th>
                <th>Provincias</th>
                <th>Mesas</th>
                <th>% Escrutado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($departamentos as $departamento)
              <tr>
                <td>{{ $departamento->id }}</td>
                <td>
                  <strong>{{ $departamento->nombre }}</strong>
                </td>
                <td>{{ $departamento->codigo }}</td>
                <td class="text-right">{{ number_format($departamento->total_inscritos) }}</td>
                <td class="text-center">{{ $departamento->provincias_count ?? 0 }}</td>
                <td class="text-center">{{ $departamento->total_mesas }}</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-{{ $departamento->porcentaje_escrutado >= 80 ? 'success' : ($departamento->porcentaje_escrutado >= 50 ? 'warning' : 'danger') }}" 
                         style="width: {{ $departamento->porcentaje_escrutado }}%"></div>
                  </div>
                  <small class="text-muted">{{ $departamento->porcentaje_escrutado }}%</small>
                </td>
                <td>
                  <a href="{{ route('departamentos.edit', $departamento->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('departamentos.show', $departamento->id) }}" class="btn btn-info btn-sm">
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