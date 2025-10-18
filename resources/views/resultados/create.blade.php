@extends('adminlte::page')

@section('title', 'Registrar Acta')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Registrar Nueva Acta</h1>
      </div>
      <div class="col-sm-6">
        <a href="{{ route('resultados.index') }}" class="btn btn-secondary float-right">
          <i class="fas fa-arrow-left"></i> Volver
        </a>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Información del Acta</h3>
          </div>
          <form action="{{ route('resultados.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              
              <!-- Selección de Mesa -->
              <div class="form-group">
                <label for="mesa_id">Mesa de Votación *</label>
                <select class="form-control select2" id="mesa_id" name="mesa_id" required style="width: 100%;">
                  <option value="">Seleccionar Mesa</option>
                  @foreach($mesas as $mesa)
                  <option value="{{ $mesa->id }}" data-info="{{ $mesa->ruta_completa }}" data-inscritos="{{ $mesa->total_inscritos }}">
                    {{ $mesa->numero_mesa }} - {{ $mesa->codigo_mesa }} ({{ $mesa->total_inscritos }} inscritos)
                  </option>
                  @endforeach
                </select>
              </div>

              <!-- Información de la Mesa -->
              <div id="mesa-info" class="alert alert-info" style="display: none;">
                <h6><i class="fas fa-info-circle"></i> Información de la Mesa Seleccionada</h6>
                <div id="mesa-details"></div>
              </div>

              <!-- Datos del Acta -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="numero_acta">Número de Acta *</label>
                    <input type="text" class="form-control" id="numero_acta" name="numero_acta" required placeholder="Ej: ACTA-001">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha_acta">Fecha y Hora del Acta *</label>
                    <input type="datetime-local" class="form-control" id="fecha_acta" name="fecha_acta" required value="{{ now()->format('Y-m-d\TH:i') }}">
                  </div>
                </div>
              </div>

              <!-- Foto del Acta -->
              <div class="form-group">
                <label for="foto_acta">Foto del Acta</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto_acta" name="foto_acta" accept="image/*">
                  <label class="custom-file-label" for="foto_acta">Seleccionar archivo</label>
                </div>
                <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB</small>
              </div>

              <hr>

              <!-- Votos por Candidato -->
              <h5>Votos por Candidato</h5>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="thead-light">
                    <tr>
                      <th>Candidato</th>
                      <th>Partido</th>
                      <th>Votos</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($candidatos->where('activo', true) as $candidato)
                    <tr>
                      <td>
                        <span class="badge" style="background-color: {{ $candidato->color_hex }}; width: 20px; height: 20px;">&nbsp;</span>
                        {{ $candidato->nombre }}
                      </td>
                      <td>{{ $candidato->partido ?? 'Independiente' }}</td>
                      <td style="width: 120px;">
                        <input type="number" name="votos[{{ $candidato->id }}]" class="form-control votos-input" value="0" min="0" data-candidato="{{ $candidato->id }}">
                      </td>
                      <td style="width: 100px;">
                        <button type="button" class="btn btn-sm btn-success btn-agregar" data-candidato="{{ $candidato->id }}">
                          <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btn-quitar" data-candidato="{{ $candidato->id }}">
                          <i class="fas fa-minus"></i>
                        </button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <!-- Votos Especiales -->
              <h5>Votos Especiales</h5>
              <div class="row">
                @foreach($tiposVotos as $tipo)
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="votos_especiales_{{ $tipo->id }}">{{ $tipo->nombre }}</label>
                    <input type="number" class="form-control" id="votos_especiales_{{ $tipo->id }}" 
                           name="votos_especiales[{{ $tipo->id }}]" value="0" min="0">
                  </div>
                </div>
                @endforeach
              </div>

              <!-- Resumen -->
              <div class="alert alert-warning">
                <div class="row text-center">
                  <div class="col-4">
                    <h4 id="total-votos">0</h4>
                    <small>Total Votos</small>
                  </div>
                  <div class="col-4">
                    <h4 id="total-inscritos">0</h4>
                    <small>Inscritos</small>
                  </div>
                  <div class="col-4">
                    <h4 id="votos-restantes">0</h4>
                    <small>Restantes</small>
                  </div>
                </div>
              </div>

            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary" id="btn-submit">
                <i class="fas fa-save"></i> Registrar Acta
              </button>
              <a href="{{ route('resultados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-4">
        <!-- Información de ayuda -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Instrucciones</h3>
          </div>
          <div class="card-body">
            <p><strong>Pasos para registrar un acta:</strong></p>
            <ol>
              <li>Seleccione la mesa de votación</li>
              <li>Ingrese el número y fecha del acta</li>
              <li>Suba la foto del acta (opcional)</li>
              <li>Registre los votos por candidato</li>
              <li>Complete los votos especiales</li>
              <li>Verifique que el total no exceda los inscritos</li>
              <li>Guarde el registro</li>
            </ol>
            <div class="alert alert-danger">
              <i class="fas fa-exclamation-triangle"></i>
              <strong>Importante:</strong> El total de votos no puede exceder el número de ciudadanos inscritos en la mesa.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>
.select2-container .select2-selection--single {
  height: 38px;
}
.votos-input {
  text-align: center;
  font-weight: bold;
}
.btn-agregar, .btn-quitar {
  width: 30px;
  height: 30px;
  padding: 0;
}
</style>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/es.js"></script>
<script>
$(document).ready(function() {
  // Inicializar Select2
  $('.select2').select2({
    language: "es",
    placeholder: "Seleccionar Mesa"
  });

  // Actualizar información de la mesa
  $('#mesa_id').change(function() {
    const selectedOption = $(this).find('option:selected');
    const mesaInfo = selectedOption.data('info');
    const totalInscritos = selectedOption.data('inscritos');
    
    if (mesaInfo && totalInscritos) {
      $('#mesa-details').html(`
        <strong>Ubicación:</strong> ${mesaInfo}<br>
        <strong>Total Inscritos:</strong> ${totalInscritos.toLocaleString()}
      `);
      $('#mesa-info').show();
      $('#total-inscritos').text(totalInscritos.toLocaleString());
      calcularTotales();
    } else {
      $('#mesa-info').hide();
      $('#total-inscritos').text('0');
    }
  });

  // Botones para agregar/quitar votos
  $('.btn-agregar').click(function() {
    const candidatoId = $(this).data('candidato');
    const input = $(`input[data-candidato="${candidatoId}"]`);
    input.val(parseInt(input.val()) + 1);
    calcularTotales();
  });

  $('.btn-quitar').click(function() {
    const candidatoId = $(this).data('candidato');
    const input = $(`input[data-candidato="${candidatoId}"]`);
    if (parseInt(input.val()) > 0) {
      input.val(parseInt(input.val()) - 1);
      calcularTotales();
    }
  });

  // Calcular totales
  function calcularTotales() {
    let totalVotos = 0;
    $('.votos-input').each(function() {
      totalVotos += parseInt($(this).val()) || 0;
    });

    // Sumar votos especiales
    $('input[name^="votos_especiales"]').each(function() {
      totalVotos += parseInt($(this).val()) || 0;
    });

    const totalInscritos = parseInt($('#total-inscritos').text().replace(/,/g, '')) || 0;
    const votosRestantes = totalInscritos - totalVotos;

    $('#total-votos').text(totalVotos.toLocaleString());
    $('#votos-restantes').text(votosRestantes.toLocaleString());

    // Validar
    const btnSubmit = $('#btn-submit');
    if (totalVotos > totalInscritos) {
      btnSubmit.prop('disabled', true).addClass('btn-danger').removeClass('btn-primary');
    } else {
      btnSubmit.prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
    }
  }

  // Calcular totales cuando cambien los inputs
  $('.votos-input, input[name^="votos_especiales"]').on('input', calcularTotales);

  // Preview del nombre del archivo
  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });
});
</script>
@endsection