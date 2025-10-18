@extends('adminlte::page')

@section('title', 'Resultados y Actas')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Resultados y Actas Registradas</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('resultados.create') }}" class="btn btn-success float-right">
          <i class="fas fa-plus"></i> Registrar Nueva Acta
        </a>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    
    <!-- Resumen de Actas -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $totalActas }}</h3>
            <p>ACTAS REGISTRADAS</p>
          </div>
          <div class="icon">
            <i class="fas fa-clipboard-list"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $actasAprobadas }}</h3>
            <p>ACTAS APROBADAS</p>
          </div>
          <div class="icon">
            <i class="fas fa-check-circle"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $actasPendientes }}</h3>
            <p>ACTAS PENDIENTES</p>
          </div>
          <div class="icon">
            <i class="fas fa-clock"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $actasObservadas }}</h3>
            <p>ACTAS OBSERVADAS</p>
          </div>
          <div class="icon">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Lista de Actas -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Lista de Actas Registradas</h3>
        <div class="card-tools">
          <div class="input-group input-group-sm" style="width: 200px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar...">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th># Acta</th>
                <th>Mesa</th>
                <th>Ubicación</th>
                <th>Fecha/Hora Acta</th>
                <th>Foto Acta</th>
                <th>Estado</th>
                <th>Votos Válidos</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($actas as $acta)
              <tr>
                <td>
                  <strong>{{ $acta->numero_acta }}</strong>
                </td>
                <td>
                  <strong>{{ $acta->mesa->numero_mesa }}</strong>
                  <br><small class="text-muted">{{ $acta->mesa->codigo_mesa }}</small>
                </td>
                <td>
                  <small>
                    {{ $acta->mesa->recinto->localidad->municipio->nombre }} → 
                    {{ $acta->mesa->recinto->localidad->nombre }} → 
                    {{ $acta->mesa->recinto->nombre }}
                  </small>
                </td>
                <td>
                  {{ $acta->fecha_acta ? $acta->fecha_acta->format('d/m/Y H:i') : 'N/A' }}
                </td>
                <td>
                  @if($acta->foto_acta_url)
                  <a href="{{ $acta->foto_acta_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Ver Acta
                  </a>
                  @else
                  <span class="badge badge-warning">Sin foto</span>
                  @endif
                </td>
                <td>
                  <span class="badge badge-{{ $acta->estado_acta_color }}">
                    {{ ucfirst($acta->estado_acta) }}
                  </span>
                  @if($acta->observaciones)
                  <br><small class="text-muted" title="{{ $acta->observaciones }}">{{ Str::limit($acta->observaciones, 30) }}</small>
                  @endif
                </td>
                <td class="text-right">
                  <strong>{{ number_format($acta->votos) }}</strong>
                </td>
                <td>
                  <a href="{{ route('resultados.mesa.edit', $acta->mesa_id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button class="btn btn-info btn-sm" onclick="verDetallesActa({{ $acta->id }})">
                    <i class="fas fa-search"></i>
                  </button>
                  @if($acta->estado_acta == 'pendiente')
                  <button class="btn btn-success btn-sm" onclick="aprobarActa({{ $acta->id }})">
                    <i class="fas fa-check"></i>
                  </button>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        {{ $actas->links() }}
      </div>
    </div>

  </div>
</section>
@endsection

@section('js')
<script>
function verDetallesActa(actaId) {
  // Implementar modal con detalles del acta
  alert('Detalles del acta: ' + actaId);
}

function aprobarActa(actaId) {
  if (confirm('¿Está seguro de aprobar esta acta?')) {
    // Implementar aprobación del acta
    alert('Acta aprobada: ' + actaId);
  }
}
</script>
@endsection