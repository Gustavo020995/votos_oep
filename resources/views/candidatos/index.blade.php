@extends('adminlte::page')

@section('title', 'Candidatos')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Gestión de Candidatos</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('candidatos.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Nuevo Candidato
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
                <th>Candidato</th>
                <th>Partido</th>
                <th>Color</th>
                <th>Total Votos</th>
                <th>Porcentaje</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($candidatos as $candidato)
              <tr>
                <td>{{ $candidato->id }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    @if($candidato->foto)
                    <img src="{{ $candidato->foto_url }}" alt="{{ $candidato->nombre }}" class="img-circle mr-3" style="width: 40px; height: 40px;">
                    @endif
                    <div>
                      <strong>{{ $candidato->nombre }}</strong>
                      @if($candidato->propuesta)
                      <br><small class="text-muted">{{ Str::limit($candidato->propuesta, 50) }}</small>
                      @endif
                    </div>
                  </div>
                </td>
                <td>{{ $candidato->partido ?? 'Independiente' }}</td>
                <td>
                  <span class="badge" style="background-color: {{ $candidato->color_hex }}; width: 30px; height: 20px;">&nbsp;</span>
                  <small>{{ $candidato->color_hex }}</small>
                </td>
                <td class="text-right">
                  <strong>{{ number_format($candidato->total_votos) }}</strong>
                </td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar" style="width: {{ $candidato->porcentaje_votos }}%; background-color: {{ $candidato->color_hex }}"></div>
                  </div>
                  <small class="text-muted">{{ $candidato->porcentaje_votos }}%</small>
                </td>
                <td>
                  <span class="badge badge-{{ $candidato->activo ? 'success' : 'danger' }}">
                    {{ $candidato->activo ? 'Activo' : 'Inactivo' }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('candidatos.edit', $candidato->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('candidatos.show', $candidato->id) }}" class="btn btn-info btn-sm">
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