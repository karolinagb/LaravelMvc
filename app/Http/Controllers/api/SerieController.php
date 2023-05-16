<?php

namespace App\Http\Controllers\api;

use App\Models\Serie;
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
}
