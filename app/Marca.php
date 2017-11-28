<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = [
        'descricao',
    ];

    protected $table = 'marcas';

/*    public function pais()
    {
        return $this->beLongsTo('App\Pais');
    }*/
}
