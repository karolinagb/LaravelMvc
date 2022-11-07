<x-layout title="Séries de {{ $serie->nome }}">

    <ul class="list-group">
        @foreach ($temporadas as $temporada)

        <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('epsodios.index', $temporada->id) }}">
            Temporada {{$temporada->numero}}
        </a>

            {{-- o laravel traz um objeto de series e n um array --}}

            <span class="badge bg-secondary">
               {{ $temporada->epsodios->count() }}
            </span>
        </li>
        @endforeach
    </ul>
</x-layout>
