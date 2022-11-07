<?php
namespace App\Http\Controllers;

use App\Models\Temporada;

class EpsodiosController
{
    public function index(int $id)
    {
        $temporada = Temporada::find($id);

        return view('epsodios.index', ['epsodios' => $temporada->epsodios]);
    }
}
