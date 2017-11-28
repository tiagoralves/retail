<?php

use Illuminate\Database\Seeder;

class LojasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lojas')->insert([
            ['pais_id' => '1','descricao'=> 'Americanas', 'url' => 'americanas.com.br', 'hora1'=>'10:00', 'hora2'=>'18:00', 'hora3' =>'23:40', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Submarino', 'url' => 'submarino.com.br', 'hora1'=>'10:30', 'hora2'=>'15:50', 'hora3' =>'21:50','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Casas Bahia', 'url' => 'casasbahia.com.br', 'hora1'=>'07:00', 'hora2'=>'11:00', 'hora3' =>'19:00','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Ponto Frio', 'url' => 'pontofrio.com.br/r', 'hora1'=>'04:00', 'hora2'=>'12:00', 'hora3' =>'20:00','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Extra', 'url' => 'extra.com.br', 'hora1'=>'05:00', 'hora2'=>'13:00', 'hora3' =>'21:00','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Mgazine Luiza', 'url' => 'magazineluiza.com.br', 'hora1'=>'06:00', 'hora2'=>'14:00', 'hora3'=>'22:00','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Walmart', 'url' => 'walmart.com.br', 'hora1'=>'07:00', 'hora2'=>'15:00', 'hora3' =>'23:00', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Ricardo Eletro', 'url' => 'ricardoeletro.com.br', 'hora1'=>'08:00', 'hora2'=>'16:00', 'hora3' =>'23:50','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Carrefour', 'url' => 'carrefour.com.br', 'hora1'=>'08:30', 'hora2'=>'16:30', 'hora3' =>'22:30','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '1','descricao'=> 'Fastshop', 'url' => 'fastshop.com.br/loja/', 'hora1'=>'09:00', 'hora2'=>'17:00', 'hora3' =>'21:00', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Walmart', 'url' => 'walmart.com.mx', 'hora1'=>'03:38', 'hora2'=>'11:38', 'hora3' =>'19:38','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Claro Shop', 'url' => 'claroshop.com', 'hora1'=>'04:38', 'hora2'=>'12:38', 'hora3' =>'20:38','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Liverpool', 'url' => 'liverpool.com.mx/tienda/home.jsp', 'hora1'=>'06:37', 'hora2'=>'14:37', 'hora3' =>'22:37','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Bestbuy', 'url' => 'bestbuy.com.mx', 'hora1'=>'07:35', 'hora2'=>'15:35', 'hora3' =>'23:35','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Costco', 'url' => 'costco.com.mx', 'hora1'=>'08:35', 'hora2'=>'16:35', 'hora3' =>'19:40','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Amazon', 'url' => 'amazon.com.mx', 'hora1'=>'08:10', 'hora2'=>'16:10', 'hora3' =>'20:17','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Elpalacio de Hierro', 'url' => 'elpalaciodehierro.com', 'hora1'=>'10:10', 'hora2'=>'14:12', 'hora3' =>'21:10','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Sears', 'url' => 'sears.com.mx', 'hora1'=>'10:15', 'hora2'=>'13:28', 'hora3' =>'20:50','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Elektra', 'url' => 'elektra.com.mx', 'hora1'=>'05:40', 'hora2'=>'17:40', 'hora3' =>'20:40','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '4','descricao'=> 'Sams', 'url' => 'sams.com.mx', 'hora1'=>'10:30', 'hora2'=>'18:30', 'hora3' =>'22:30','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '2','descricao'=> 'Falabella', 'url' => 'falabella.com/falabella-cl/', 'hora1'=>'03:05', 'hora2'=>'11:05', 'hora3' =>'19:05','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '3','descricao'=> 'Ripley - Colombia', 'url' => 'simple.ripley.cl', 'hora1'=>'04:05', 'hora2'=>'12:05', 'hora3' =>'20:05', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '3','descricao'=> 'Paris', 'url' => 'paris.cl/tienda/es/paris', 'hora1'=>'05:05', 'hora2'=>'13:05', 'hora3' =>'21:05','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '3','descricao'=> 'Abcdin', 'url' => 'abcdin.cl', 'hora1'=>'06:05', 'hora2'=>'14:05', 'hora3' =>'22:05','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '3','descricao'=> 'Tiendas Jumbo', 'url' => 'tiendasjumbo.co', 'hora1'=>'07:10', 'hora2'=>'14:10', 'hora3' =>'22:10', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '3','descricao'=> 'Alkosto', 'url' => 'alkosto.com',  'hora1'=>'08:05', 'hora2'=>'16:05', 'hora3' =>'23:05', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '3','descricao'=> 'Exito', 'url' => 'exito.com', 'hora1'=>'09:05', 'hora2'=>'17:05', 'hora3' =>'22:15', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '3','descricao'=> 'Falabella', 'url' => 'falabella.com.co/falabella-co', 'hora1'=>'09:08', 'hora2'=>'17:08', 'hora3' =>'22:08','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '5','descricao'=> 'Garbarino', 'url' => 'garbarino.com', 'hora1'=>'03:30', 'hora2'=>'11:30', 'hora3' =>'19:30', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '5','descricao'=> 'Fravega', 'url' => 'fravega.com', 'hora1'=>'04:30', 'hora2'=>'12:30', 'hora3' =>'20:30','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '5','descricao'=> 'Compumundo', 'url' => 'compumundo.com.ar', 'hora1'=>'05:30', 'hora2'=>'13:30', 'hora3' =>'21:30','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '5','descricao'=> 'Ribeiro', 'url' => 'ribeiro.com.ar','hora1'=>'06:30', 'hora2'=>'14:30', 'hora3' =>'22:30', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '6','descricao'=> 'Falabella', 'url' => 'falabella.com.pe/falabella-pe', 'hora1'=>'03:08', 'hora2'=>'11:08', 'hora3' =>'19:08','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '6','descricao'=> 'Ripley', 'url' => 'simple.ripley.com.pe', 'hora1'=>'4:08', 'hora2'=>'12:08', 'hora3' =>'20:08','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '7','descricao'=> 'Panafoto', 'url' => 'panafoto.com', 'hora1'=>'03:35', 'hora2'=>'11:35', 'hora3' =>'19:35','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '7','descricao'=> 'Gollo', 'url' => 'gollotienda.com', 'hora1'=>'04:35', 'hora2'=>'12:35', 'hora3' =>'20:35','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '7','descricao'=> 'Hifi', 'url' => 'hifi.com.do', 'hora1'=>'05:35', 'hora2'=>'13:35', 'hora3' =>'19:15','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '7','descricao'=> 'Tienda Monge', 'url' => 'tiendamonge.com', 'hora1'=>'', 'hora2'=>'', 'hora3' =>'','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '7','descricao'=> 'Comandato', 'url' => 'comandato.com', 'hora1'=>'07:30', 'hora2'=>'15:30', 'hora3' =>'23:30','created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pais_id' => '7','descricao'=> 'Ripley', 'url' => 'https://simple.ripley.cl/','hora1'=>'03:25', 'hora2'=>'12:25', 'hora3' =>'20:25', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }
}
