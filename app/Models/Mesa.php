<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;
 
    protected $fillable = ['recinto_id', 'numero_mesa', 'codigo_mesa', 'total_inscritos', 'estado'];

    protected $appends = [
        'total_votos', 
        'porcentaje_participacion', 
        'total_votos_especiales', 
        'total_votos_emitidos',
        'ruta_completa'
    ];

    public function recinto()
    {
        return $this->belongsTo(Recinto::class);
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function resultados()
    {
        return $this->hasMany(Resultado::class);
    }

    public function votosEspeciales()
    {
        return $this->hasMany(VotoEspecial::class);
    }

    public function getTotalVotosAttribute()
    {
        return $this->resultados->sum('votos');
    }

    public function getTotalVotosEspecialesAttribute()
    {
        return $this->votosEspeciales->sum('cantidad');
    }

    public function getTotalVotosEmitidosAttribute()
    {
        return $this->total_votos + $this->total_votos_especiales;
    }

    public function getPorcentajeParticipacionAttribute()
    {
        if ($this->total_inscritos == 0) return 0;
        return round(($this->total_votos_emitidos / $this->total_inscritos) * 100, 2);
    }

    public function getRutaCompletaAttribute()
    {
        $recinto = $this->recinto;
        $localidad = $recinto->localidad;
        $municipio = $localidad->municipio;
        $provincia = $municipio->provincia;
        $departamento = $provincia->departamento;

        return "{$departamento->nombre} → {$provincia->nombre} → {$municipio->nombre} → {$localidad->nombre} → {$recinto->nombre}";
    }

    public function getEstadisticasCompletasAttribute()
    {
        $votosBlancos = $this->votosEspeciales()->whereHas('tipoVoto', function($q) {
            $q->where('codigo', 'blanco');
        })->first()->cantidad ?? 0;

        $votosNulos = $this->votosEspeciales()->whereHas('tipoVoto', function($q) {
            $q->where('codigo', 'nulo');
        })->first()->cantidad ?? 0;

        return [
            'total_inscritos' => $this->total_inscritos,
            'total_votos_emitidos' => $this->total_votos_emitidos,
            'votos_validos' => $this->total_votos,
            'votos_blancos' => $votosBlancos,
            'votos_nulos' => $votosNulos,
            'participacion' => $this->porcentaje_participacion,
            'abstencion' => $this->total_inscritos - $this->total_votos_emitidos,
        ];
    }
}