<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $fillable = [
        'pais_id',
        'link',
        'arquivo'
    ];

    protected $table = 'screenshots';
}
