<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = ['provincia_id', 'nombre', 'codigo', 'total_inscritos'];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }

    public function recintos()
    {
        return $this->hasManyThrough(Recinto::class, Localidad::class);
    }

    public function mesas()
    {
        return Mesa::whereHas('recinto.localidad', function($query) {
            $query->where('municipio_id', $this->id);
        });
    }

    // Atributos calculados
    public function getTotalMesasAttribute()
    {
        return $this->mesas()->count();
    }

    public function getMesasEscrutadasAttribute()
    {
        return $this->mesas()->where('estado', 'conteo_finalizado')->count();
    }

    public function getPorcentajeEscrutadoAttribute()
    {
        return $this->total_mesas > 0 ? round(($this->mesas_escrutadas / $this->total_mesas) * 100, 2) : 0;
    }
}