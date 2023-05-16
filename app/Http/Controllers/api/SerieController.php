<?php

namespace App\Http\Controllers\api;

use App\Models\Serie;
use App\Http\Controllers\Controller;
use App\Http\Requests\SerieFormRequest;

class SerieController extends Controller
{
    public function getSeries()
    {
        return Serie::all();
    }

    public function store(SerieFormRequest $request)
    {
        return response()
        ->json(Serie::create($request->all()), 201); //Laravel ja sabe parsear para json, mas a gente coloca isso pra deixar explícito no código
    }
}
