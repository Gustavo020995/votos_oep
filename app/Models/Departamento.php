<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Departamento extends Model
{
    use HasFactory;
     protected $table = 'departamentos';

    protected $fillable = ['nombre', 'codigo', 'total_inscritos'];

    public function provincias()
    {
        return $this->hasMany(Provincia::class);
    }

    public function municipios()
    {
        return $this->hasManyThrough(Municipio::class, Provincia::class);
    }

    // Método optimizado para obtener mesas con joins
    public function mesasQuery()
    {
        return Mesa::join('recintos', 'mesas.recinto_id', '=', 'recintos.id')
            ->join('localidades', 'recintos.localidad_id', '=', 'localidades.id')
            ->join('municipios', 'localidades.municipio_id', '=', 'municipios.id')
            ->join('provincias', 'municipios.provincia_id', '=', 'provincias.id')
            ->where('provincias.departamento_id', $this->id)
            ->select('mesas.*');
    }

    // Atributos calculados OPTIMIZADOS
    public function getTotalMesasAttribute()
    {
        return $this->mesasQuery()->count();
    }

    public function getMesasEscrutadasAttribute()
    {
        return $this->mesasQuery()->where('mesas.estado', 'conteo_finalizado')->count();
    }

    public function getPorcentajeEscrutadoAttribute()
    {
        return $this->total_mesas > 0 ? round(($this->mesas_escrutadas / $this->total_mesas) * 100, 2) : 0;
    }

    public function getTotalVotosValidosAttribute()
    {
        return DB::table('resultados')
            ->join('mesas', 'resultados.mesa_id', '=', 'mesas.id')
            ->join('recintos', 'mesas.recinto_id', '=', 'recintos.id')
            ->join('localidades', 'recintos.localidad_id', '=', 'localidades.id')
            ->join('municipios', 'localidades.municipio_id', '=', 'municipios.id')
            ->join('provincias', 'municipios.provincia_id', '=', 'provincias.id')
            ->where('provincias.departamento_id', $this->id)
            ->sum('resultados.votos');
    }

    public function getTotalVotosBlancosAttribute()
    {
        return DB::table('votos_especiales') // ← NOMBRE CORREGIDO
            ->join('mesas', 'votos_especiales.mesa_id', '=', 'mesas.id')
            ->join('recintos', 'mesas.recinto_id', '=', 'recintos.id')
            ->join('localidades', 'recintos.localidad_id', '=', 'localidades.id')
            ->join('municipios', 'localidades.municipio_id', '=', 'municipios.id')
            ->join('provincias', 'municipios.provincia_id', '=', 'provincias.id')
            ->join('tipo_votos', 'votos_especiales.tipo_voto_id', '=', 'tipo_votos.id')
            ->where('provincias.departamento_id', $this->id)
            ->where('tipo_votos.codigo', 'blanco')
            ->sum('votos_especiales.cantidad');
    }

    public function getTotalVotosNulosAttribute()
    {
        return DB::table('votos_especiales') // ← NOMBRE CORREGIDO
            ->join('mesas', 'votos_especiales.mesa_id', '=', 'mesas.id')
            ->join('recintos', 'mesas.recinto_id', '=', 'recintos.id')
            ->join('localidades', 'recintos.localidad_id', '=', 'localidades.id')
            ->join('municipios', 'localidades.municipio_id', '=', 'municipios.id')
            ->join('provincias', 'municipios.provincia_id', '=', 'provincias.id')
            ->join('tipo_votos', 'votos_especiales.tipo_voto_id', '=', 'tipo_votos.id')
            ->where('provincias.departamento_id', $this->id)
            ->where('tipo_votos.codigo', 'nulo')
            ->sum('votos_especiales.cantidad');
    }

    public function getTotalVotosEmitidosAttribute()
    {
        return $this->total_votos_validos + $this->total_votos_blancos + $this->total_votos_nulos;
    }

    public function getParticipacionAttribute()
    {
        return $this->total_inscritos > 0 ? round(($this->total_votos_emitidos / $this->total_inscritos) * 100, 2) : 0;
    }

    public function getAbstencionAttribute()
    {
        return $this->total_inscritos - $this->total_votos_emitidos;
    }
}