<?php

namespace App\Http\Controllers\api;

use App\Models\Serie;
use App\Http\Controllers\Controller;

class SerieController extends Controller
{
    public function getSeries()
    {
        return Serie::all();
    }
}
