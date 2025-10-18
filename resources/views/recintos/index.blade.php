@extends('adminlte::page')

@section('title', 'Recintos')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Gestión de Recintos</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('recintos.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Nuevo Recinto
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
                <th>Localidad</th>
                <th>Municipio</th>
                <th>Provincia</th>
                <th>Departamento</th>
                <th>Total Inscritos</th>
                <th>Mesas</th>
                <th>% Escrutado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recintos as $recinto)
              <tr>
                <td>{{ $recinto->id }}</td>
                <td>
                  <strong>{{ $recinto->nombre }}</strong>
                  @if($recinto->direccion)
                  <br><small class="text-muted">{{ $recinto->direccion }}</small>
                  @endif
                </td>
                <td>{{ $recinto->codigo }}</td>
                <td>{{ $recinto->localidad->nombre }}</td>
                <td>{{ $recinto->localidad->municipio->nombre }}</td>
                <td>{{ $recinto->localidad->municipio->provincia->nombre }}</td>
                <td>{{ $recinto->localidad->municipio->provincia->departamento->nombre }}</td>
                <td class="text-right">{{ number_format($recinto->total_inscritos) }}</td>
                <td class="text-center">{{ $recinto->total_mesas }}</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-{{ $recinto->porcentaje_escrutado >= 80 ? 'success' : ($recinto->porcentaje_escrutado >= 50 ? 'warning' : 'danger') }}" 
                         style="width: {{ $recinto->porcentaje_escrutado }}%"></div>
                  </div>
                  <small class="text-muted">{{ $recinto->porcentaje_escrutado }}%</small>
                </td>
                <td>
                  <a href="{{ route('recintos.edit', $recinto->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('recintos.show', $recinto->id) }}" class="btn btn-info btn-sm">
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