<?php

namespace Database\Seeders;

use App\Models\Provincia;
use App\Models\Departamento;
use Illuminate\Database\Seeder;

class ProvinciaSeeder extends Seeder
{
    public function run()
    {
        $departamentos = Departamento::all();

        foreach ($departamentos as $departamento) {
            for ($i = 1; $i <= 3; $i++) {
                Provincia::create([
                    'departamento_id' => $departamento->id,
                    'nombre' => "Provincia {$i} - {$departamento->nombre}",
                    'codigo' => "{$departamento->codigo}-P{$i}",
                    'total_inscritos' => rand(50000, 200000)
                ]);
            }
        }
    }
}