{{-- podemos passar como parametro a variavel que criamos no layout --}}
<x-layout title="Séries">

<a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Adicionar</a>

{{-- slot é o que colocamos dentro da tag personalizada --}}
<ul class="list-group">
    @foreach ($series as $serie)

    <li class="list-group-item d-flex justify-content-between align-items-center">{{$serie->nome}}

        {{-- o laravel traz um objeto de series e n um array --}}

        <form action="{{ route('series.destroy', $serie->id) }}" method="POST">
            @csrf

            {{-- Html so trabalha com post e get, se quisermos usar outro método temos que informar assim --}}
            {{-- Apesar de estarmos enviando um formulario com post, o php vai entender como delete e usar a rota de delete que definimos --}}
            @method('DELETE')
            <button class="btn btn-danger btn-sm">X</button>
        </form>

    </li>

    @endforeach
</ul>

{{-- @ para o blade nao achar que é uma variavel q vou colocar pois quero apenas imprimir isso --}}
{{-- @{{ nome }} --}}

{{-- Para fazer uma variavel do php para o javascript (encapsula o array em um json) --}}
{{-- <script>
    const series = {{ Js::from($series) }};
</script> --}}

{{-- nome do componente de layout que criamos --}}
</x-layout>
