<?php

namespace Database\Seeders;

use App\Models\Localidad;
use App\Models\Municipio;
use Illuminate\Database\Seeder;

class LocalidadSeeder extends Seeder
{
    public function run()
    {
        $municipios = Municipio::all();

        foreach ($municipios as $municipio) {
            for ($i = 1; $i <= 2; $i++) {
                Localidad::create([
                    'municipio_id' => $municipio->id,
                    'nombre' => "Localidad {$i} - {$municipio->nombre}",
                    'codigo' => "{$municipio->codigo}-L{$i}",
                    'total_inscritos' => rand(5000, 15000)
                ]);
            }
        }
    }
}