<?php
namespace App\Http\Controllers;

use App\Models\Epsodio;
use App\Models\Temporada;
use Illuminate\Http\Request;

class EpsodiosController
{
    public function index(int $id)
    {
        $temporada = Temporada::find($id);

        return view('epsodios.index', ['epsodios' => $temporada->epsodios, 'idTemporada' => $id]);
    }

    public function update(Request $request, int $id)
    {
        $temporada = Temporada::find($id);

        $epsodiosAssistidos = $request->epsodios;

        $temporada->epsodios->each(function (Epsodio $epsodio) use ($epsodiosAssistidos)
        {
            $epsodio->assistido = in_array($epsodio->id, $epsodiosAssistidos);
        });

        $temporada->push(); //salva as alterações da model atual e seus relacionamentos

        return to_route('epsodios.index', $temporada->id);
    }
}
