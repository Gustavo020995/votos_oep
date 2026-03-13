<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="40%">Número de Acta:</th>
                    <td><strong>{{ $resultado->numero_acta }}</strong></td>
                </tr>
                <tr>
                    <th>Mesa:</th>
                    <td>{{ $resultado->mesa->numero_mesa }} ({{ $resultado->mesa->codigo_mesa }})</td>
                </tr>
                <tr>
                    <th>Recinto:</th>
                    <td>{{ $resultado->mesa->recinto->nombre }}</td>
                </tr>
                <tr>
                    <th>Localidad:</th>
                    <td>{{ $resultado->mesa->recinto->localidad->nombre }}</td>
                </tr>
                <tr>
                    <th>Municipio:</th>
                    <td>{{ $resultado->mesa->recinto->localidad->municipio->nombre }}</td>
                </tr>
                <tr>
                    <th>Fecha Acta:</th>
                    <td>{{ $resultado->fecha_acta ? $resultado->fecha_acta->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Estado:</th>
                    <td>
                        @php
                            $estadoColor = [
                                'aprobada' => 'success',
                                'pendiente' => 'warning',
                                'observada' => 'danger',
                                'rechazada' => 'dark'
                            ];
                        @endphp
                        <span class="badge badge-{{ $estadoColor[$resultado->estado_acta] ?? 'secondary' }} p-2">
                            {{ ucfirst($resultado->estado_acta) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-6">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="40%">Total Votos:</th>
                    <td><strong>{{ number_format($totalVotos) }}</strong></td>
                </tr>
                <tr>
                    <th colspan="2" class="pt-3">Votos por Candidato:</th>
                </tr>
                @foreach($actaCompleta as $voto)
                <tr>
                    <td>{{ $voto->candidato->nombre ?? 'Sin candidato' }}:</td>
                    <td class="text-right"><strong>{{ number_format($voto->votos) }}</strong></td>
                </tr>
                @endforeach
                
                @if($votosEspeciales->count() > 0)
                <tr>
                    <th colspan="2" class="pt-3">Votos Especiales:</th>
                </tr>
                @foreach($votosEspeciales as $votoEspecial)
                <tr>
                    <td>{{ $votoEspecial->tipoVoto->nombre ?? 'Voto especial' }}:</td>
                    <td class="text-right">{{ number_format($votoEspecial->cantidad) }}</td>
                </tr>
                @endforeach
                @endif
            </table>
        </div>
    </div>
    
    @if($resultado->observaciones)
    <hr>
    <div class="row">
        <div class="col-12">
            <h6>Observaciones:</h6>
            <div class="alert alert-secondary">
                {{ $resultado->observaciones }}
            </div>
        </div>
    </div>
    @endif
    
    @if($resultado->foto_acta)
    <hr>
    <div class="row">
        <div class="col-12">
            <h6>Foto del Acta:</h6>
            <img src="{{ Storage::url($resultado->foto_acta) }}" alt="Foto del acta" class="img-fluid img-thumbnail" style="max-height: 400px;">
        </div>
    </div>
    @endif
</div>