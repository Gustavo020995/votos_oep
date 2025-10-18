<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recinto extends Model
{
    use HasFactory;

    protected $fillable = ['localidad_id', 'nombre', 'codigo', 'direccion', 'total_inscritos'];

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function mesas()
    {
        return $this->hasMany(Mesa::class);
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