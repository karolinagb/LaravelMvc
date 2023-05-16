<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

class TemporadasController extends Controller
{
    public function index(int $id)
    {
        //para não buscar a serie, poderia fazer:
        // $temporadas = Temporada::query()
            //->with('epsodios')
            //->where('serie_id', $id)
            //->get();

        $serie = Serie::find($id);

        //collection do eloquent
        //eager loading para trazer as temporadas com os epsodios
        $temporadas = $serie->temporadas()->with('epsodios')->get();

        return view('temporadas.index')->with('temporadas', $temporadas)
            ->with('serie', $serie);
    }
}
