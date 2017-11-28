<?php

use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('categorias')->insert([
            ['descricao' => 'SMARTPHONES','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['descricao' => 'TVS','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['descricao' => 'REFRIGERATORS','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['descricao' => 'WASHING MACHINES','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['descricao' => 'NOTEBOOKS','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['descricao' => 'ACESSORIOS','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ]);

    }
}
