<?php

namespace Database\Seeders;

use App\Models\TipoVoto;
use Illuminate\Database\Seeder;

class TipoVotoSeeder extends Seeder
{
    public function run()
    {
        $tiposVotos = [
            ['nombre' => 'Votos Válidos', 'codigo' => 'valido', 'color_hex' => '#28a745'],
            ['nombre' => 'Votos en Blanco', 'codigo' => 'blanco', 'color_hex' => '#6c757d'],
            ['nombre' => 'Votos Nulos', 'codigo' => 'nulo', 'color_hex' => '#dc3545'],
            ['nombre' => 'Votos Impugnados', 'codigo' => 'impugnado', 'color_hex' => '#ffc107'],
        ];

        foreach ($tiposVotos as $tipo) {
            TipoVoto::create($tipo);
        }
    }
}