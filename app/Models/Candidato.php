<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'partido', 'color_hex', 'foto', 'propuesta', 'activo'];

    protected $appends = ['total_votos', 'porcentaje_votos', 'foto_url'];

    public function resultados()
    {
        return $this->hasMany(Resultado::class);
    }

    public function getTotalVotosAttribute()
    {
        return $this->resultados->sum('votos');
    }

    public function getPorcentajeVotosAttribute()
    {
        $totalVotosValidos = Resultado::sum('votos');
        return $totalVotosValidos > 0 ? round(($this->total_votos / $totalVotosValidos) * 100, 2) : 0;
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('img/default-candidate.jpg');
    }
}
