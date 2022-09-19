{{-- podemos passar como parametro a variavel que criamos no layout --}}
<x-layout title="Séries">

{{-- slot é o que colocamos dentro da tag personalizada --}}
<ul>
@foreach ($series as $serie)
<li>{{$serie}}</li>
@endforeach
</ul>

{{-- nome do componente de layout que criamos --}}
</x-layout>
