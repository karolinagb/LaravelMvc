<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Epsodio extends Model
{
    use HasFactory;
    protected $fillable = ['numero'];

    public $timestamps = false; //informar que timestamp não será utilizado

    protected $casts = [
        'assistido' => 'bool'
    ];

    public function temporada()
    {
        //belongsTo é o inverso do relacionamento OneToMany (diz-se "Um epsodio pertence a uma temporada")
        return $this->belongsTo(Temporada::class);
    }

    //crriando um acessor - forma de acessar uma propriedade
    //posso trocar isso por usar a propriedade casts
    // protected function assistido(): Attribute
    // {
    //     // return Attribute::make()
    //     return new Attribute(
    //         get: fn ($assistido) => (bool) $assistido
    //     ); //parametro1 = obter o dado, parametro2 = definir o dado
    // }

    //adicionando um escopo local
    // public function scopeAssistido(Builder $query)
    // {
    //     //Retorna todos os espsódio onde o campo assistido é true
    //     // $query->where('assistido', true);
    // }
}
