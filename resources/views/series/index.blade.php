{{-- podemos passar como parametro a variavel que criamos no layout --}}
<x-layout title="Séries" :mensagem-sucesso="$mensagemSucesso">

@auth
    <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Adicionar</a>
@endauth

{{-- slot é o que colocamos dentro da tag personalizada --}}
<ul class="list-group">
    @foreach ($series as $serie)

    <li class="list-group-item d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center">
            <img src="{{ asset('storage/' . ($serie->caminho_capa ?: 'capa_serie/sem-foto.png')) }}" width="100" alt="Capa da série"
            class="img-thumbnail me-3">
            @auth <a href="{{ route('temporadas.index', $serie->id) }}"> @endauth
                {{$serie->nome}}
            @auth </a> @endauth
        </div>

        {{-- o laravel traz um objeto de series e n um array --}}

        @auth
            <span class="d-flex">
                <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-primary btn-sm">E</a>
                {{-- Para exclusao usamos o form pois precisamos de um POST para excluir e não de um get que é oq o link a faz --}}
                <form action="{{ route('series.destroy', $serie->id) }}" method="POST" class="ms-2">
                    @csrf

                    {{-- Html so trabalha com post e get, se quisermos usar outro método temos que informar assim --}}
                    {{-- Apesar de estarmos enviando um formulario com post, o php vai entender como delete e usar a rota de delete que definimos --}}
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">X</button>
                </form>
            </span>
        @endauth
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
