<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable = [
        'pais'
    ];

    protected $table = 'paises';

    public function lojas()
    {
        return $this->hasMany('App\Loja');
    }

    public function scraps()
    {
        return $this->hasMany('App\Scrap');
    }
}
