<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arquivos extends Model
{
    protected $table = 'modulo_cadastro';
    protected $fillable = ['aula_descricao','link_aula','updated_at','created_at'];
}
