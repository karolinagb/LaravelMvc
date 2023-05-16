<!DOCTYPE html>
<html>
<head>
    <title>{{$title}} - Controle de Séries</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css')}}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a href="{{ route('series.index') }}" class="navbar-brand">Home</a>

        {{-- diretiva do blade para verificar se existe usuário autenticado --}}
        @auth
        {{-- se o usuario n estiver autenticado, não é mostrado o botão --}}
            <a href="{{ route('usuarios.logout') }}">Sair</a>
        @endauth

        @guest
            {{-- Será exibido caso não tenha usuário logado --}}
            <a href="{{ route('login') }}">Entrar</a>
        @endguest
    </div>
</nav>

<div class="container">

    <h1>{{$title}}</h1>

    @isset($mensagemSucesso)
    <div class="alert alert-success">
        {{ $mensagemSucesso }}
    </div>
    @endisset

     {{-- esssa variavel errors é criada pelo laravel sempre que tem algum erro na requisição --}}
     @if ($errors->any())
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
                 {{-- Nesse erro temos uma message bag/sacola de informações --}}
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
    @endif

    {{$slot}}

</div>
</body>
</html>
