<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
 protected $table = 'provincias';
    protected $fillable = ['departamento_id', 'nombre', 'codigo', 'total_inscritos'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }

    public function localidades()
    {
        return $this->hasManyThrough(Localidad::class, Municipio::class);
    }

    public function recintos()
    {
        return $this->hasManyThrough(Recinto::class, Localidad::class);
    }

    public function mesas()
    {
        return Mesa::whereHas('recinto.localidad.municipio', function($query) {
            $query->where('provincia_id', $this->id);
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
