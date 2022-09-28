<x-layout title="Editar Série {{ $serie->nome }}">
    {{-- Posso colocar esse : antes de action e o blade ja entende que oq vem dentro do igual é código --}}
    <x-series.form :action="route('series.update', $serie->id)" :nome="$serie->nome" :update="true"/>
</x-layout>
