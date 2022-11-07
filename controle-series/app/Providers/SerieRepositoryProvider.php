<?php

namespace App\Providers;

use App\Repositories\ISerieRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\EloquentSerieRepository;

class SerieRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    // public function register()
    // {
    //     //Ensina ao service container o que tem que fazer para ele devolver uma instância do repositório

    //     $this->app->bind(ISerieRepository::class, EloquentSerieRepository::class);
    // }

    //dá para substituir por isso:

    public array $bindings =
    [
        ISerieRepository::class => EloquentSerieRepository::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //inicializar alguma coisa que quisermos depois dos serviços terem sido registrados
    }
}
