@extends('adminlte::page')

@section('title', 'Mesas de Votación')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Gestión de Mesas de Votación</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('mesas.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Nueva Mesa
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
                <th>Número Mesa</th>
                <th>Código</th>
                <th>Recinto</th>
                <th>Localidad</th>
                <th>Municipio</th>
                <th>Provincia</th>
                <th>Departamento</th>
                <th>Total Inscritos</th>
                <th>Votos Emitidos</th>
                <th>Participación</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($mesas as $mesa)
              <tr>
                <td>{{ $mesa->id }}</td>
                <td>
                  <strong>{{ $mesa->numero_mesa }}</strong>
                </td>
                <td>{{ $mesa->codigo_mesa }}</td>
                <td>{{ $mesa->recinto->nombre }}</td>
                <td>{{ $mesa->recinto->localidad->nombre }}</td>
                <td>{{ $mesa->recinto->localidad->municipio->nombre }}</td>
                <td>{{ $mesa->recinto->localidad->municipio->provincia->nombre }}</td>
                <td>{{ $mesa->recinto->localidad->municipio->provincia->departamento->nombre }}</td>
                <td class="text-right">{{ number_format($mesa->total_inscritos) }}</td>
                <td class="text-right">{{ number_format($mesa->total_votos_emitidos) }}</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-{{ $mesa->porcentaje_participacion >= 80 ? 'success' : ($mesa->porcentaje_participacion >= 50 ? 'warning' : 'danger') }}" 
                         style="width: {{ $mesa->porcentaje_participacion }}%"></div>
                  </div>
                  <small class="text-muted">{{ $mesa->porcentaje_participacion }}%</small>
                </td>
                <td>
                  <span class="badge badge-{{ $mesa->estado == 'conteo_finalizado' ? 'success' : ($mesa->estado == 'conteo_en_proceso' ? 'warning' : 'secondary') }}">
                    {{ ucfirst(str_replace('_', ' ', $mesa->estado)) }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('mesas.edit', $mesa->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
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