<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;
   protected $table = 'localidades';
    protected $fillable = ['municipio_id', 'nombre', 'codigo', 'total_inscritos'];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function recintos()
    {
        return $this->hasMany(Recinto::class);
    }

    public function mesas()
    {
        return $this->hasManyThrough(Mesa::class, Recinto::class);
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