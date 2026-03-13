@extends('adminlte::page')

@section('title', 'Dashboard OEP')

@section('content')
<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Dashboard OEP</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    
    <!-- Estadísticas Principales -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ number_format($estadisticasGenerales['total_inscritos']) }}</h3>
            <p>CIUDADANOS HABILITADOS</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $estadisticasGenerales['mesas_escrutadas'] }}/{{ $estadisticasGenerales['total_mesas'] }}</h3>
            <p>MESAS ESCRUTADAS</p>
            <div class="progress progress-sm mt-2">
              <div class="progress-bar bg-light" style="width: {{ $estadisticasGenerales['porcentaje_escrutado'] }}%"></div>
            </div>
            <small class="text-white">{{ $estadisticasGenerales['porcentaje_escrutado'] }}%</small>
          </div>
          <div class="icon">
            <i class="fas fa-clipboard-check"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ number_format($estadisticasGenerales['votos_emitidos']) }}</h3>
            <p>VOTOS EMITIDOS</p>
            <small class="text-white">{{ $estadisticasGenerales['participacion'] }}% Participación</small>
          </div>
          <div class="icon">
            <i class="fas fa-vote-yea"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ number_format($estadisticasGenerales['abstencion']) }}</h3>
            <p>ABSTENCIONES</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-slash"></i>
          </div>
        </div>
      </div>
    </div>
 <!-- Detalle de Estadísticas (Estilo de la imagen) -->
    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detalle</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <td><strong>Total</strong></td>
                <td class="text-right">Percentage</td>
              </tr>
              <tr>
                <td>Votos Válidos</td>
                <td class="text-right">{{ number_format($estadisticasGenerales['votos_validos']) }} ({{ number_format(($estadisticasGenerales['votos_validos'] / $estadisticasGenerales['votos_emitidos']) * 100, 2) }}%)</td>
              </tr>
              <tr>
                <td>Votos Blancos</td>
                <td class="text-right">{{ number_format($estadisticasGenerales['votos_blancos']) }} ({{ number_format(($estadisticasGenerales['votos_blancos'] / $estadisticasGenerales['votos_emitidos']) * 100, 2) }}%)</td>
              </tr>
              <tr>
                <td>Votos Nulos</td>
                <td class="text-right">{{ number_format($estadisticasGenerales['votos_nulos']) }} ({{ number_format(($estadisticasGenerales['votos_nulos'] / $estadisticasGenerales['votos_emitidos']) * 100, 2) }}%)</td>
              </tr>
              <tr>
                <td><strong>Votos Emitidos</strong></td>
                <td class="text-right"><strong>{{ number_format($estadisticasGenerales['votos_emitidos']) }}</strong></td>
              </tr>
              <tr>
                <td>Ciudadanos Habilitados por Actas Computadas</td>
                <td class="text-right">{{ number_format($estadisticasGenerales['total_inscritos']) }}</td>
              </tr>
              <tr>
                <td>Total Ciudadanos Habilitados</td>
                <td class="text-right">{{ number_format($estadisticasGenerales['total_inscritos']) }}</td>
              </tr>
              <tr>
                <td>Total Actas Computadas</td>
                <td class="text-right">{{ $estadisticasGenerales['mesas_escrutadas'] }} (100%)</td>
              </tr>
              <tr>
                <td>Total Actas Anuladas</td>
                <td class="text-right">0 (0%)</td>
              </tr>
              <tr>
                <td>Total Actas Habilitadas</td>
                <td class="text-right">{{ $estadisticasGenerales['total_mesas'] }} (100%)</td>
              </tr>
              <tr>
                <td>Participación por Actas Computadas</td>
                <td class="text-right">{{ $estadisticasGenerales['participacion'] }}%</td>
              </tr>
            </table>
          </div>
        </div>
      </div>

    <!-- Distribución de Votos -->
 
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tipo de Votos</h3>
          </div>
          <div class="card-body">
            <canvas id="tipoVotosChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Resultados por Candidato -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Resultados por Candidato</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th>Candidato / Partido</th>
                    <th>Votos</th>
                    <th>Porcentaje</th>
                    <th>Progreso</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($candidatos->sortByDesc('total_votos') as $candidato)
                  <tr>
                    <td>
                      <span class="badge" style="background-color: {{ $candidato->color_hex }}; width: 20px; height: 20px;">&nbsp;</span>
                      <strong>{{ $candidato->nombre }}</strong>
                      @if($candidato->partido)
                      <br><small class="text-muted">{{ $candidato->partido }}</small>
                      @endif
                    </td>
                    <td class="text-right">
                      <strong>{{ number_format($candidato->total_votos) }}</strong>
                    </td>
                    <td class="text-right">
                      {{ $candidato->porcentaje_votos }}%
                    </td>
                    <td>
                      <div class="progress progress-sm">
                        <div class="progress-bar" style="width: {{ $candidato->porcentaje_votos }}%; background-color: {{ $candidato->color_hex }}"></div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mapa de Progreso por Departamento -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Progreso por Departamento</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Departamento</th>
                    <th>Mesas Total</th>
                    <th>Mesas Escrutadas</th>
                    <th>% Escrutado</th>
                    <th>Votos Válidos</th>
                    <th>Participación</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($departamentos as $departamento)
                  <tr>
                    <td>
                      <strong>{{ $departamento->nombre }}</strong>
                      <br><small class="text-muted">{{ $departamento->codigo }}</small>
                    </td>
                    <td class="text-center">{{ $departamento->total_mesas }}</td>
                    <td class="text-center">{{ $departamento->mesas_escrutadas }}</td>
                    <td>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-{{ $departamento->porcentaje_escrutado >= 80 ? 'success' : ($departamento->porcentaje_escrutado >= 50 ? 'warning' : 'danger') }}" 
                             style="width: {{ $departamento->porcentaje_escrutado }}%"></div>
                      </div>
                      <small class="text-muted">{{ $departamento->porcentaje_escrutado }}%</small>
                    </td>
                    <td class="text-right">{{ number_format($departamento->total_votos_validos) }}</td>
                    <td class="text-right">{{ $departamento->participacion }}%</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

@section('js')
<script>
// Gráfico de distribución de votos
const votosCtx = document.getElementById('votosChart').getContext('2d');
const votosChart = new Chart(votosCtx, {
    type: 'doughnut',
    data: {
        labels: ['Votos Válidos', 'Votos en Blanco', 'Votos Nulos', 'Abstenciones'],
        datasets: [{
            data: [
                {{ $estadisticasGenerales['votos_validos'] }},
                {{ $estadisticasGenerales['votos_blancos'] }},
                {{ $estadisticasGenerales['votos_nulos'] }},
                {{ $estadisticasGenerales['abstencion'] }}
            ],
            backgroundColor: ['#28a745', '#6c757d', '#dc3545', '#ffc107'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = {{ $estadisticasGenerales['total_inscritos'] }};
                        const value = context.raw;
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${context.label}: ${value.toLocaleString()} (${percentage}%)`;
                    }
                }
            }
        }
    }
});

// Gráfico de tipo de votos
const tipoVotosCtx = document.getElementById('tipoVotosChart').getContext('2d');
const tipoVotosChart = new Chart(tipoVotosCtx, {
    type: 'bar',
    data: {
        labels: ['Votos Válidos', 'Votos Blancos', 'Votos Nulos'],
        datasets: [{
            label: 'Cantidad de Votos',
            data: [
                {{ $estadisticasGenerales['votos_validos'] }},
                {{ $estadisticasGenerales['votos_blancos'] }},
                {{ $estadisticasGenerales['votos_nulos'] }}
            ],
            backgroundColor: ['#28a745', '#6c757d', '#dc3545'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.dataset.label}: ${context.raw.toLocaleString()}`;
                    }
                }
            }
        }
    }
});
</script>
@endsection