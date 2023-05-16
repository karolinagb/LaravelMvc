<x-layout title="Séries de {{ $serie->nome }}">

<div class="text-center">
    <img src="{{ asset('storage/' . $serie->caminho_capa) }}" alt="Capa da série" class="img-fluid"
    style="height: 400px">
</div>

    <ul class="list-group">
        @foreach ($temporadas as $temporada)

        <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('epsodios.index', $temporada->id) }}">
            Temporada {{$temporada->numero}}
        </a>

            {{-- o laravel traz um objeto de series e n um array --}}

            <span class="badge bg-secondary">
                {{ $temporada->numeroDeEpsodiosAssistidos() }} / {{ $temporada->epsodios->count() }}
            </span>
            {{-- <span class="badge bg-secondary">
                {{ $temporada->epsodios()->assistido()->count() }}
                {{ $temporada->epsodios->filter(fn ($epsodio) => $epsodio->assistido)->count() }}
             </span> --}}
        </li>
        @endforeach
    </ul>
</x-layout>
