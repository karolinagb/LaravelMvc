<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ele busca uma tabela chamada series, é padrão do eloquent
class Serie extends Model
{
    use HasFactory;

    //o create ignora tudo que nao esta na propriedade fillable
    protected $fillable = ['nome']; //campos que permito ser adicionados por atribuição em massa
}
