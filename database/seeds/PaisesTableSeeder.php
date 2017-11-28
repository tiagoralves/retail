<?php

use Illuminate\Database\Seeder;

class PaisesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('paises')->insert([
            ['pais' => 'Brasil','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais' => 'Chile','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais' => 'Colômbia','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais' => 'México','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais' => 'Argentina','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais' => 'Peru','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais' => 'Sela','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]

        ]);
    }
}
