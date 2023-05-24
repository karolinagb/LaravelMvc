<?php

namespace App\Http\Controllers\api;

use App\Models\Serie;
use App\Models\Temporada;
use App\Http\Controllers\Controller;
use App\Repositories\ISerieRepository;
use App\Http\Requests\SerieFormRequest;

class SerieController extends Controller
{
    public function __construct(private ISerieRepository $serieRepository)
    {
    }
    public function getSeries()
    {
        return Serie::all();
    }

    public function store(SerieFormRequest $request)
    {
        return response()
        ->json($this->serieRepository->add($request), 201); //Laravel ja sabe parsear para json, mas a gente coloca isso pra deixar explícito no código
    }

    public function show(int $id)
    {
        // $serie = Serie::whereId($id)
        //     ->with('temporadas.epsodios')
        //     ->first();

        //posso trocar por isso:
        $serie = Serie::with('temporadas.epsodios')->find($id);

        if($serie ===null)
        {
            return response()->json(['message' => 'Série não encontrada'], 404);
        }

        return response()
            ->json($serie, 200);
    }

    public function update(int $id, SerieFormRequest $request)
    {
        $serie = Serie::find($id);
        $serie->fill($request->all());
        $serie->save();

        // retorno de uma resposta que não contenha a série, já que não fizemos um `SELECT`
        // Serie::where(‘id’, $series)->update($request->all());

        return response()->json($serie, 200);
    }

    public function destroy(int $id)
    {
        // $serie = Serie::find($id);
        // $serie->delete();
        //Posso simplificar o que está em cima para não ter que procurar a model antes:
        Serie::destroy($id);
        // return response()->json(204);
        //ou
        return response()->noContent();
    }

    public function getTemporadas(int $id)
    {
        $serie = Temporada::where('serie_id', $id)->get();
        return $serie;
    }

    public function getEpsodios(int $id)
    {
        $serie = Serie::find($id);
        return $serie->epsodios;
    }

}
