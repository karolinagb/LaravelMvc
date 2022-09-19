{{-- podemos passar como parametro a variavel que criamos no layout --}}
<x-layout title="Séries">

<a href="/series/criar">Adicionar</a>

{{-- slot é o que colocamos dentro da tag personalizada --}}
<ul class="list-group">
    @foreach ($series as $serie)
    <li class="list-group-item">{{$serie}}</li>
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
