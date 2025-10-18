<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVoto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'color_hex', 'activo'];

    public function votosEspeciales()
    {
        return $this->hasMany(VotoEspecial::class);
    }
}