<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epsodio extends Model
{
    use HasFactory;

    public function temporada()
    {
        return $this->belongsTo(Temporada::class);
    }
}
