<?php

namespace Database\Seeders;

use App\Models\Candidato;
use Illuminate\Database\Seeder;

class CandidatoSeeder extends Seeder
{
    public function run()
    {
        $candidatos = [
            [
                'nombre' => 'MOVIMIENTO AL SOCIALISMO - INSTRUMENTO POLÍTICO POR LA SOBERANÍA DE LOS PUEBLOS',
                'partido' => 'MAS-IPSP',
                'color_hex' => '#8B0000',
                'propuesta' => 'Propuesta del MAS-IPSP'
            ],
            [
                'nombre' => 'COMUNIDAD CIUDADANA',
                'partido' => 'CC',
                'color_hex' => '#FFD700',
                'propuesta' => 'Propuesta de Comunidad Ciudadana'
            ],
            [
                'nombre' => 'FRENTE PARA LA VICTORIA',
                'partido' => 'FPV',
                'color_hex' => '#00008B',
                'propuesta' => 'Propuesta del Frente para la Victoria'
            ],
            [
                'nombre' => 'PARTIDO DEMÓCRATA CRISTIANO',
                'partido' => 'PDC',
                'color_hex' => '#228B22',
                'propuesta' => 'Propuesta del PDC'
            ],
            [
                'nombre' => 'VOTO EN BLANCO',
                'partido' => null,
                'color_hex' => '#808080',
                'propuesta' => null
            ]
        ];

        foreach ($candidatos as $candidato) {
            Candidato::create($candidato);
        }
    }
}