<?php

namespace Database\Seeders;

use App\Models\Recinto;
use App\Models\Localidad;
use Illuminate\Database\Seeder;

class RecintoSeeder extends Seeder
{
    public function run()
    {
        $localidades = Localidad::all();

        foreach ($localidades as $localidad) {
            for ($i = 1; $i <= 2; $i++) {
                Recinto::create([
                    'localidad_id' => $localidad->id,
                    'nombre' => "Recinto {$i} - {$localidad->nombre}",
                    'codigo' => "{$localidad->codigo}-R{$i}",
                    'direccion' => "Calle Principal #{$i}",
                    'total_inscritos' => rand(1000, 3000)
                ]);
            }
        }
    }
}