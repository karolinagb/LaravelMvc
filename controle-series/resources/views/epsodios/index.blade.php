<x-layout title="Epsodios">

<form method="post">
    @csrf
    <ul class="list-group">
        @foreach ($epsodios as $epsodio)

        <li class="list-group-item d-flex justify-content-between align-items-center">
            Epsodio {{$epsodio->numero}}

            {{-- name="epsodios[]" - vira um array quando chega no controlador --}}
            <input type="checkbox" name="epsodios[]" value="{{ $epsodio->id }}">
        </li>
        @endforeach

    </ul>
    <button class="btn btn-primary mt-2 mb-2">Salvar</button>
</form>
</x-layout>
