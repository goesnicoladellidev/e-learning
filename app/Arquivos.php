<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arquivos extends Model
{
    protected $table = 'arquivos';
    protected $fillable = ['descricao','url'];
}
