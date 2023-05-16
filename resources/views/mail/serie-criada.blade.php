<x-mail::message>
    # {{ $nomeSerie }} criada

A série {{ $nomeSerie }} com {{ $qtdTemporadas }} e {{ $epsodiosPorTemporadas }} epsódios por temporada foi criada.

Acesse aqui:
<x-mail::button :url="route('epsodios.index', $idSerie)">
    Ver Série
</x-mail::button>

</x-mail::message>
