<?php
namespace App\Repositories;

use App\Models\Serie;
use App\Models\Epsodio;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SerieFormRequest;

class EloquentSerieRepository implements ISerieRepository
{
    public function add(SerieFormRequest $request): Serie
    {
        return DB::transaction(function () use ($request) {

            $serie = Serie::create([
                'nome' => $request->nome,
                'caminho_capa' => $request->caminhoCapa
            ]);

            $temporadas = [];

            for($i = 1; $i <= $request->quantTemporadas; $i++){
                //usando o relacionamento para criar temporadas
                //poderia fazer temporada::create, mas ia ter que ficar informando a chave estrangeira do relacionamento
                //temporadas() pega o relacionamento, propriedade temporadas pega a coleção de temporadas

                //Esse codigo gera uma query para cada inserção
                //Vamos criar um array primeiro e adicionar as temporadas nele
                //     $temporada = $serie->temporadas()->create([
                //     'numero' => $i
                // ]);
                $temporadas[] = [
                    //nesse caso não dá para usar o relacionamento para não ter que colocar chave estrangeira
                    'serie_id' => $serie->id,
                    'numero' => $i
                ];
            }

            Temporada::insert($temporadas); //posso passar um array para o insert ao invés do sql

            $epsodios = [];
            foreach ($serie->temporadas as $temporada) {
                for($j = 1; $j <= $request->epsodios; $j++){
                    $epsodios[] = [
                        'temporada_id' => $temporada->id,
                        'numero' => $j
                    ];
                }
            }

            Epsodio::insert($epsodios);

            /** @var Series $series */
            return $serie;
        }); // 2 parâmetro (número de tentativas) = Tenta executar 5 vezes a transação em caso de deadlock
        //Isso é importante caso usemos uma transação que depende das mesmas tabelas da primeira transação
    }
}
