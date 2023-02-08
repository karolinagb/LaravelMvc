<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Repositories\ISerieRepository;
use App\Http\Requests\SerieFormRequest;
use Illuminate\Foundation\Testing\WithFaker;
use App\Repositories\EloquentSerieRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SerieRepositoryTest extends TestCase
{
     //apaga o banco e executa as migrations antes de rodar o teste
    use RefreshDatabase;

    public function test_serie_criada_epsodios_e_temporadas_tambem_criadas()
    {
        //arrange
        /** @var EloquentSerieRepository $repository */
        $repository = $this->app->make(ISerieRepository::class);

         /** @var EloquentSerieRepository $request */
        $request = new SerieFormRequest();
        $request->nome = 'Teste ambiente diferente';
        $request->quantTemporadas = 3;
        $request->epsodios = 2;

        //act
        $repository->add($request);

        //assert
        $this->assertDatabaseHas('series', ['nome' => 'Teste ambiente diferente']);
        $this->assertDatabaseHas('temporadas', ['numero' => 3]);
        $this->assertDatabaseHas('epsodios', ['numero' => 2]);
    }
}
