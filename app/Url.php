<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'categoria_id',
        'loja_id',
        'url',
        'status',
        'device'
    ];

    protected $table = 'urls';
}
