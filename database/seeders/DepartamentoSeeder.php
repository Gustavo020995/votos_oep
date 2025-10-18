<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    public function run()
    {
        $departamentos = [
            ['nombre' => 'La Paz', 'codigo' => 'LP', 'total_inscritos' => 2500000],
            ['nombre' => 'Cochabamba', 'codigo' => 'CB', 'total_inscritos' => 1800000],
            ['nombre' => 'Santa Cruz', 'codigo' => 'SC', 'total_inscritos' => 2800000],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
    }
}