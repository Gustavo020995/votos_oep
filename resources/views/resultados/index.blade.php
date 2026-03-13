@extends('adminlte::page')

@section('title', 'Resultados y Actas')

@section('content_header')
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
@stop

@section('content')
<div class="container-fluid">
    
    @php
        $estadoColor = [
            'aprobada' => 'success',
            'pendiente' => 'warning',
            'observada' => 'danger',
            'rechazada' => 'dark'
        ];
    @endphp

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

    <!-- Filtros rápidos -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group flex-wrap">
                <a href="{{ route('resultados.index') }}" 
                   class="btn btn-sm {{ !request('estado') ? 'btn-info' : 'btn-outline-info' }}">
                    Todas <span class="badge badge-light ml-1">{{ $totalActas }}</span>
                </a>
                <a href="{{ route('resultados.index', ['estado' => 'aprobada']) }}" 
                   class="btn btn-sm {{ request('estado') == 'aprobada' ? 'btn-success' : 'btn-outline-success' }}">
                    Aprobadas <span class="badge badge-light ml-1">{{ $actasAprobadas }}</span>
                </a>
                <a href="{{ route('resultados.index', ['estado' => 'pendiente']) }}" 
                   class="btn btn-sm {{ request('estado') == 'pendiente' ? 'btn-warning' : 'btn-outline-warning' }}">
                    Pendientes <span class="badge badge-light ml-1">{{ $actasPendientes }}</span>
                </a>
                <a href="{{ route('resultados.index', ['estado' => 'observada']) }}" 
                   class="btn btn-sm {{ request('estado') == 'observada' ? 'btn-danger' : 'btn-outline-danger' }}">
                    Observadas <span class="badge badge-light ml-1">{{ $actasObservadas }}</span>
                </a>
            </div>
            
            @if(request('search') || request('estado'))
            <a href="{{ route('resultados.index') }}" class="btn btn-sm btn-secondary ml-2">
                <i class="fas fa-times"></i> Limpiar filtros
            </a>
            @endif
        </div>
    </div>

    <!-- Tabla de Actas -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Actas Registradas</h3>
            <div class="card-tools">
                <form action="{{ route('resultados.index') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Buscar acta o mesa..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 8%"># Acta</th>
                            <th style="width: 8%">Mesa</th>
                            <th class="d-none d-md-table-cell" style="width: 25%">Ubicación</th>
                            <th class="d-none d-lg-table-cell" style="width: 12%">Fecha/Hora</th>
                            <th class="text-center" style="width: 8%">Foto</th>
                            <th class="text-center" style="width: 10%">Estado</th>
                            <th class="text-right" style="width: 8%">Votos</th>
                            <th class="text-center" style="width: 21%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actas as $acta)
                        <tr>
                            <td class="text-center align-middle">
                                <strong>{{ $acta->numero_acta }}</strong>
                            </td>
                            
                            <td class="align-middle">
                                <strong>{{ $acta->mesa->numero_mesa }}</strong>
                                <br><small class="text-muted d-none d-sm-inline">{{ $acta->mesa->codigo_mesa }}</small>
                            </td>
                            
                            <td class="d-none d-md-table-cell align-middle">
                                @php
                                    $municipio = optional($acta->mesa->recinto->localidad->municipio)->nombre ?? 'N/A';
                                    $localidad = optional($acta->mesa->recinto->localidad)->nombre ?? 'N/A';
                                    $recinto = optional($acta->mesa->recinto)->nombre ?? 'N/A';
                                    $ubicacionCompleta = "$municipio → $localidad → $recinto";
                                @endphp
                                <small title="{{ $ubicacionCompleta }}" data-toggle="tooltip">
                                    <i class="fas fa-map-marker-alt text-info mr-1"></i>
                                    {{ Str::limit($municipio, 15) }} →
                                    {{ Str::limit($localidad, 10) }} →
                                    {{ Str::limit($recinto, 10) }}
                                </small>
                            </td>
                            
                            <td class="d-none d-lg-table-cell align-middle">
                                <small>
                                    <i class="far fa-calendar-alt text-info mr-1"></i>
                                    {{ $acta->fecha_acta ? $acta->fecha_acta->format('d/m/Y') : 'N/A' }}
                                    <br>
                                    <i class="far fa-clock text-info mr-1"></i>
                                    {{ $acta->fecha_acta ? $acta->fecha_acta->format('H:i') : '' }}
                                </small>
                            </td>
                            
                            <td class="text-center align-middle">
                                @if($acta->foto_acta_url)
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" title="Opciones de foto">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ $acta->foto_acta_url }}" target="_blank" class="dropdown-item">
                                            <i class="fas fa-external-link-alt"></i> Ver original
                                        </a>
                                        <a href="{{ $acta->foto_acta_url }}" download class="dropdown-item">
                                            <i class="fas fa-download"></i> Descargar
                                        </a>
                                    </div>
                                </div>
                                @else
                                <span class="badge badge-warning" title="Sin foto">📷</span>
                                @endif
                            </td>
                            
                            <td class="text-center align-middle">
                                <span class="badge badge-{{ $estadoColor[strtolower($acta->estado_acta)] ?? 'secondary' }} p-2" data-toggle="tooltip" title="Estado actual">
                                    @switch(strtolower($acta->estado_acta))
                                        @case('aprobada')
                                            <i class="fas fa-check-circle mr-1"></i>
                                            @break
                                        @case('pendiente')
                                            <i class="fas fa-clock mr-1"></i>
                                            @break
                                        @case('observada')
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            @break
                                        @default
                                            <i class="fas fa-question-circle mr-1"></i>
                                    @endswitch
                                    {{ ucfirst($acta->estado_acta) }}
                                </span>
                                @if($acta->observaciones)
                                <br>
                                <small class="text-muted" title="{{ $acta->observaciones }}" data-toggle="tooltip">
                                    <i class="fas fa-comment"></i>
                                    {{ Str::limit($acta->observaciones, 15) }}
                                </small>
                                @endif
                            </td>
                            
                            <td class="text-right align-middle">
                                <strong class="h5">{{ number_format($acta->votos) }}</strong>
                            </td>
                            
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <!-- Botón Editar (siempre visible) -->
                                    <a href="{{ route('resultados.mesa.edit', $acta->mesa_id) }}" 
                                       class="btn btn-warning btn-sm" 
                                       data-toggle="tooltip" 
                                       title="Editar acta">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Botón Ver Detalles (siempre visible) -->
                                    <button type="button" 
                                            class="btn btn-info btn-sm" 
                                            onclick="verDetallesActa({{ $acta->id }})"
                                            data-toggle="tooltip" 
                                            title="Ver detalles">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    
                                    <!-- Botón Aprobar (solo para pendientes) -->
                                    @if(strtolower($acta->estado_acta) == 'pendiente')
                                    <button type="button" 
                                            class="btn btn-success btn-sm" 
                                            onclick="aprobarActa({{ $acta->id }})"
                                            data-toggle="tooltip" 
                                            title="Aprobar acta">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @endif
                                    
                                    <!-- Botón Marcar como Observada (solo para pendientes) -->
                                    @if(strtolower($acta->estado_acta) == 'pendiente')
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="marcarObservada({{ $acta->id }})"
                                            data-toggle="tooltip" 
                                            title="Marcar como observada">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </button>
                                    @endif
                                    
                                    <!-- Botón Editar Observaciones (solo para observadas) -->
                                    @if(strtolower($acta->estado_acta) == 'observada')
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="revisarActa({{ $acta->id }})"
                                            data-toggle="tooltip" 
                                            title="Editar observaciones">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay actas registradas</h5>
                                <p class="text-muted mb-3">Comienza registrando la primera acta</p>
                                <a href="{{ route('resultados.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Registrar Primera Acta
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($actas->hasPages())
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <p class="text-muted mb-0">
                        Mostrando {{ $actas->firstItem() ?? 0 }} - {{ $actas->lastItem() ?? 0 }} 
                        de {{ $actas->total() }} resultados
                    </p>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous --}}
                                <li class="page-item {{ $actas->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $actas->previousPageUrl() }}" rel="prev">Anterior</a>
                                </li>

                                @php
                                    $start = max(1, $actas->currentPage() - 2);
                                    $end = min($actas->lastPage(), $actas->currentPage() + 2);
                                @endphp
                                
                                @if($start > 1)
                                    <li class="page-item"><a class="page-link" href="{{ $actas->url(1) }}">1</a></li>
                                    @if($start > 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                @for($page = $start; $page <= $end; $page++)
                                    <li class="page-item {{ $page == $actas->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $actas->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if($end < $actas->lastPage())
                                    @if($end < $actas->lastPage() - 1)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item"><a class="page-link" href="{{ $actas->url($actas->lastPage()) }}">{{ $actas->lastPage() }}</a></li>
                                @endif

                                {{-- Next --}}
                                <li class="page-item {{ !$actas->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $actas->nextPageUrl() }}" rel="next">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Modal para detalles -->
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="modalDetallesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetallesLabel">
                        <i class="fas fa-file-alt mr-2"></i>
                        Detalles del Acta
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detallesActaContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando detalles...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('css')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .small-box {
        margin-bottom: 20px;
        transition: transform 0.2s;
    }
    .small-box:hover {
        transform: translateY(-2px);
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }
    .pagination {
        margin: 0;
    }
    .page-link {
        padding: 0.3rem 0.6rem;
        font-size: 0.875rem;
    }
    .dropdown-menu {
        min-width: 160px;
    }
    .dropdown-item i {
        width: 18px;
        margin-right: 5px;
    }
    
    @media (max-width: 768px) {
        .table {
            font-size: 0.85rem;
        }
        .btn-sm {
            padding: 0.25rem 0.4rem;
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.5rem;
        }
        h1 {
            font-size: 1.5rem;
        }
        .small-box h3 {
            font-size: 1.5rem;
        }
        .small-box p {
            font-size: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .btn-group .btn {
            padding: 0.2rem 0.3rem;
            font-size: 0.7rem;
        }
        .page-link {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }
    
    .modal.fade .modal-dialog {
        transition: transform 0.2s ease-out;
        transform: scale(0.95);
    }
    .modal.show .modal-dialog {
        transform: scale(1);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: background-color 0.2s;
    }
    
    .tooltip-inner {
        background-color: #343a40;
        max-width: 300px;
        font-size: 0.8rem;
    }
    .bs-tooltip-auto[x-placement^=top] .arrow::before, 
    .bs-tooltip-top .arrow::before {
        border-top-color: #343a40;
    }
</style>
@endsection

@section('js')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CSRF Token para AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
    $('.dropdown-toggle').dropdown();
});

function verDetallesActa(actaId) {
    $('#modalDetalles').modal('show');
    $('#detallesActaContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando detalles del acta...</p>
        </div>
    `);
    
    $.ajax({
        url: '{{ route("actas.detalles", ["id" => ":id"]) }}'.replace(':id', actaId),
        method: 'GET',
        success: function(response) {
            $('#detallesActaContent').html(response);
        },
        error: function(xhr) {
            let errorMsg = 'Error al cargar los detalles';
            try {
                let response = JSON.parse(xhr.responseText);
                errorMsg = response.message || response.error || errorMsg;
            } catch(e) {}
            
            $('#detallesActaContent').html(`
                <div class="alert alert-danger m-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    ${errorMsg}
                </div>
            `);
        }
    });
}

function aprobarActa(actaId) {
    Swal.fire({
        title: '¿Aprobar acta?',
        text: "Esta acción confirmará los resultados del acta",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                text: 'Aprobando acta',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            
            $.ajax({
                url: '{{ route("actas.aprobar", ["id" => ":id"]) }}'.replace(':id', actaId),
                method: 'POST',
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Aprobada!',
                        text: response.message,
                        timer: 2000
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    let msg = 'Error al aprobar';
                    try {
                        let response = JSON.parse(xhr.responseText);
                        msg = response.message || response.error || msg;
                    } catch(e) {}
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg
                    });
                }
            });
        }
    });
}

function marcarObservada(actaId) {
    Swal.fire({
        title: 'Marcar como observada',
        text: "Ingrese las observaciones para esta acta",
        input: 'textarea',
        inputPlaceholder: 'Describa el motivo de la observación...',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Guardar como observada',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            if (!value) {
                return 'Debe ingresar las observaciones';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            
            $.ajax({
                url: '{{ route("actas.revisar", ["id" => ":id"]) }}'.replace(':id', actaId),
                method: 'POST',
                data: {
                    observaciones: result.value
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Observada!',
                        text: 'El acta ha sido marcada como observada',
                        timer: 2000
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    let msg = 'Error al guardar';
                    try {
                        let response = JSON.parse(xhr.responseText);
                        msg = response.message || response.error || msg;
                    } catch(e) {}
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg
                    });
                }
            });
        }
    });
}

function revisarActa(actaId) {
    Swal.fire({
        title: 'Editar observaciones',
        text: "Modifique las observaciones del acta",
        input: 'textarea',
        inputPlaceholder: 'Escriba las observaciones...',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Guardar cambios',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => !value ? 'Debe ingresar observaciones' : null
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Guardando...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            
            $.ajax({
                url: '{{ route("actas.revisar", ["id" => ":id"]) }}'.replace(':id', actaId),
                method: 'POST',
                data: {
                    observaciones: result.value
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: response.message,
                        timer: 2000
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    let msg = 'Error al guardar';
                    try {
                        let response = JSON.parse(xhr.responseText);
                        msg = response.message || response.error || msg;
                    } catch(e) {}
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg
                    });
                }
            });
        }
    });
}

function limpiarFiltros() {
    window.location.href = "{{ route('resultados.index') }}";
}
</script>
@endsection