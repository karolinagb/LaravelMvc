<?php

namespace App\Providers;

use App\Events\SerieApagada;
use App\Events\SerieCriada;
use App\Listeners\EmailUsuariosSobreSerieCriada;
use App\Listeners\ExclusaoImagemSerieApagada;
use App\Listeners\LogSerieCriada;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    //$listen = propriedade para mapear o evento para o seu listener
    //serve para informar q quando dado evento acontecer, a ação de determinado listener deve ser executada
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        SerieCriada::class => [
            EmailUsuariosSobreSerieCriada::class,
            LogSerieCriada::class
        ],

        SerieApagada::class => [
            ExclusaoImagemSerieApagada::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
