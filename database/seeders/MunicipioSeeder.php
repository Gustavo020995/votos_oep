<?php

namespace Database\Seeders;

use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Database\Seeder;

class MunicipioSeeder extends Seeder
{
    public function run()
    {
        $provincias = Provincia::all();

        foreach ($provincias as $provincia) {
            for ($i = 1; $i <= 2; $i++) {
                Municipio::create([
                    'provincia_id' => $provincia->id,
                    'nombre' => "Municipio {$i} - {$provincia->nombre}",
                    'codigo' => "{$provincia->codigo}-M{$i}",
                    'total_inscritos' => rand(10000, 50000)
                ]);
            }
        }
    }
}