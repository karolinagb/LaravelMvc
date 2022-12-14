<?php
namespace App\Http\Controllers;

use App\Models\Epsodio;
use App\Models\Temporada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EpsodiosController
{
    public function index(int $id)
    {
        $temporada = Temporada::find($id);

                return view('epsodios.index',
                [
                    'epsodios' => $temporada->epsodios,
                    'idTemporada' => $id,
                    'mensagemSucesso' => session('mensagem.sucesso')
                ]);
    }

    public function update(Request $request, Temporada $temporada)
    {
        // $temporada = Temporada::find($id);

        DB::beginTransaction();

        $epsodiosAssistidos = $request->epsodios;

        //Porque as arrow functions retornam o valor da expressão utilizada.
        //Alternativa correta! Toda arrow function no PHP retorna o valor da expressão que nós
        //utilizamos nela. Isso é um problema porque o método each vai ser interrompido se a função
        //passada pra ele retornar false. Então quando nós tivéssemos o primeiro episódio que
        //tivesse watched = false, esse valor seria retornado e o loop se encerraria.
        $temporada->epsodios->each(function (Epsodio $epsodio) use ($epsodiosAssistidos)
        {
            $epsodio->assistido = in_array($epsodio->id, $epsodiosAssistidos);
        });


        $temporada->push(); //salva as alterações da model atual e seus relacionamentos

        DB::commit();

        return to_route('epsodios.index', $temporada->id)
        ->with('mensagem.sucesso', 'Epsódios marcados como assistidos');
    }
}
