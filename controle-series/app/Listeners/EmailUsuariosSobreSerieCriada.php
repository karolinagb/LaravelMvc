<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\SerieCriada as SerieCriadaEvento;
use App\Mail\SeriesCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

//Esse listener já possui um método que adiciona os envios de email em tarefas, porém o listener em si
//está sendo executado de forma síncrona, ou seja, assim que o evento é despachado, esse listener é
//executado. O usuário não precisa esperar que todos os e-mails sejam enviados porque isso está assíncrono,
//mas o usuário precisa aguardar que a gente busque todos os e-mail's dos usuários e adicione um por um
//na fila. Então também temos que transformar esse listener em algo assíncrono implementando ShouldQueue
class EmailUsuariosSobreSerieCriada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SerieCriadaEvento  $event
     * @return void
     */
    public function handle(SerieCriadaEvento $event)
    {
        $listaUsuarios = User::all();

        foreach ($listaUsuarios as $index => $usuario) {

            $email = new SeriesCreated(
                $event->serieNome,
                $event->serieId,
                $event->serieQuantTemporadas,
                $event->serieEpsodios
            );

            //$request->user() = pegar o usuário logado
            // Mail::to($usuario)->queue($email);

            //Aqui estamos definindo para de 2 em 2 segundos processar, isso é para que não exceda
            //a quantidade de e-mails do mailtrap por 10 segundos.
            $tempo = now()->addSeconds($index * 2);

            //later atrasa um pouco o processamento de acordo com um tempo especificado
            Mail::to($usuario)->later($tempo, $email);

            //2 segundos entre cada e-mail para não atingir o limite do mailtrap
            // sleep(2);
        }
    }
}
