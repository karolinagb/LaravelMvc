<!DOCTYPE html>
<html>
<head>
    <title>{{$title}} - Controle de Séries</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css')}}">
</head>
<body>

<div class="container">

    <h1>{{$title}}</h1>

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
