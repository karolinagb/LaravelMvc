<x-layout title="Nova série">
    <x-series.form action="{{ route('series.store') }}"
    {{-- old() - pega da minha flash session a requisição anterior que foi adicionada pela validação --}}
        :nome="old('nome')" :update="false"/>

    {{-- usando rotas nomeadas --}}
    {{-- <form action="{{ route('series.store') }}" method="post"> --}}
        {{-- existe um ataque, uma falha de segurança que podemos ter em formulários que o Laravel nos obriga a
        tratar, é um de cross site request forgery, é basicamente a possibilidade de outras pessoas forjarem
        uma requisição de outro site para o meu, ou alguma coisa assim. --}}
        {{-- [04:38] É um ataque relativamente simples, mas com esse nome ele parece mais complexo, mas basicamente o que precisamos fazer
            para corrigir é, recebemos uma informação do servidor, sempre que essa página de formulário for carregada, essa página aqui.

        [04:54] Então precisamos enviar de volta essa informação para que lá no nosso back-end, saibamos que esta
        informação realmente foi enviada por esse formulário e não de algum outro lugar, então embora a solução pareça
        complexa, para corrigirmos basta no nosso formulário adicionar @csrf, essa diretiva do blade, ele já cuida de
        todos os detalhes para nós. --}}
        {{-- @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id=”nome” name="nome" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form> --}}
</x-layout>
