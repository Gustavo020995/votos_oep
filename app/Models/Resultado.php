<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesa_id', 
        'candidato_id', 
        'votos', 
        'foto_acta', 
        'numero_acta', 
        'fecha_acta',
        'estado_acta',
        'observaciones'
    ];

    protected $casts = [
        'fecha_acta' => 'datetime',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function getFotoActaUrlAttribute()
    {
        return $this->foto_acta ? asset('storage/' . $this->foto_acta) : null;
    }

    public function getEstadoActaColorAttribute()
    {
        return match($this->estado_acta) {
            'aprobada' => 'success',
            'rechazada' => 'danger',
            'observada' => 'warning',
            default => 'secondary',
        };
    }
}