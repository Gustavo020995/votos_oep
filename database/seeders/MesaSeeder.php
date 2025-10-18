<?php

namespace Database\Seeders;

use App\Models\Mesa;
use App\Models\Recinto;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    public function run()
    {
        $recintos = Recinto::all();

        foreach ($recintos as $recinto) {
            for ($i = 1; $i <= 3; $i++) {
                Mesa::create([
                    'recinto_id' => $recinto->id,
                    'numero_mesa' => "MESA-{$i}",
                    'codigo_mesa' => "{$recinto->codigo}-ME{$i}",
                    'total_inscritos' => rand(200, 400),
                    'estado' => ['pendiente', 'conteo_en_proceso', 'conteo_finalizado'][rand(0, 2)]
                ]);
            }
        }
    }
}