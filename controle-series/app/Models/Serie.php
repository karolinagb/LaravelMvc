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
    // protected $primaryKey = 'id'; -> definir primary key, o padrão já é o campo id

    //Não criamos uma propriedade para o relacionamento mas sim um método
    public function temporadas()
    {
        //temos que retornar um tipo de relacionamento, no caso series tem muitas temporadas - 1-N
        //foreignKey: definir o nome da chave estrangeira
        //localkey = caso a chave estrangeira referenciasse uma coluna na tabela Series que não é a chave primaria, uso localkey para definir a
            //coluna. O padrão é sempre id, mas posso trocar isso na propriedae de primaryKey
        return $this->hasMany(Temporada::class, foreignKey:'serie_id', localKey: 'id');
    }
}
