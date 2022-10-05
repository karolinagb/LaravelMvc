<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ele busca uma tabela chamada series, é padrão do eloquent
class Serie extends Model
{
    use HasFactory;

    //o create ignora tudo que nao esta na propriedade fillable
    protected $fillable = ['nome']; //campos que permito ser adicionados por atribuição em massa
    // protected $primaryKey = 'id'; -> definir primary key, o padrão já é o campo id

    //Sempre que eu buscar series, vai vir as temporadas - eager loading
    // protected $with = ['temporadas'];

    //Não criamos uma propriedade para o relacionamento mas sim um método
    public function temporadas()
    {
        //temos que retornar um tipo de relacionamento, no caso series tem muitas temporadas - 1-N
        //foreignKey: definir o nome da chave estrangeira
        //localkey = caso a chave estrangeira referenciasse uma coluna na tabela Series que não é a chave primaria, uso localkey para definir a
            //coluna. O padrão é sempre id, mas posso trocar isso na propriedae de primaryKey
        return $this->hasMany(Temporada::class, foreignKey:'serie_id', localKey: 'id');
    }

    //Podemos criar um escopo de busca onde sempre que buscar as series elas virão ordenadas por nome
    //escopos locais = pega as série de uma forma em um escopo específico
    //escopo global = sempre que pegar a série, independente de onde for, o escopo vai ser aplicado
    //Adiciono os escopos no método booted que é executado pelo Laravel - quando essa model for inicializada,
        //é adicionado o escopo
    protected static function booted()
    {
        self::addGlobalScope('ordenação', function (Builder $queryBuilder)
        {
            $queryBuilder->orderBy('nome');
        });
    }

    //posso fazer um escopo local onde usuario é igual a ativo por exemplo:
    // public function scopeActive(Builder $queryBuilder)
    // {
    //     return $queryBuilder->where('active', true);
    // }
}
