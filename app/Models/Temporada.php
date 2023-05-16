<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    use HasFactory;
    protected $fillable = ['numero'];

    public function serie()
    {
        return $this->belongsTo(Serie::class); //pertence a uma serie
    }

    public function epsodios()
    {
        return $this->hasMany(Epsodio::class);
    }

    public function numeroDeEpsodiosAssistidos(): int
    {
        return $this->epsodios->filter(fn ($epsodio) => $epsodio->assistido)->count();
    }
}
