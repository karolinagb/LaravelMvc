<?php

namespace App\Listeners;

use App\Events\SerieCriada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

// ShouldQueue = quando o evento que gera a execução desse listener for dispached, uma tarefa vai ser
// criada para executar esse listener (assíncrono) depois e não na hora (síncrono)
class LogSerieCriada implements ShouldQueue
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
     * @param  \App\Events\SerieCriada  $event
     * @return void
     */
    public function handle(SerieCriada $event)
    {
        Log::info("Série {$event->serieNome} criada com sucesso");
    }
}
