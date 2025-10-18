<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotoEspecial extends Model
{
    use HasFactory;
     protected $table = 'votos_especiales';
    protected $fillable = ['mesa_id', 'tipo_voto_id', 'cantidad'];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function tipoVoto()
    {
        return $this->belongsTo(TipoVoto::class);
    }
}