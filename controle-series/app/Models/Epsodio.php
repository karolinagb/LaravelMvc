<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epsodio extends Model
{
    use HasFactory;
    protected $fillable = ['numero'];

    public $timestamps = false; //informar que timestamp não será utilizado

    public function temporada()
    {
        //belongsTo é o inverso do relacionamento OneToMany (diz-se "Um epsodio pertence a uma temporada")
        return $this->belongsTo(Temporada::class);
    }
}
