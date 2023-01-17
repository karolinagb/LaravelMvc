<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf

    @if($update)
    @method('PUT')
    @endif

    <div class="row mb-3">
        <div class="col-8">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id=”nome” name="nome" class="form-control"
            @isset($nome)value="{{ $nome }}"@endisset autofocus>
        </div>
        <div class="col-2">
            <label for="quantTemporadas" class="form-label">Nº temporadas:</label>
            <input type="text" id=quantTemporadas name="quantTemporadas" class="form-control"
            @isset($quantTemporadas)value="{{ $quantTemporadas }}"@endisset>
        </div>
        <div class="col-2">
            <label for="epsodios" class="form-label">Epsódios:</label>
            <input type="text" id=”epsodios” name="epsodios" class="form-control"
            @isset($epsodios)value="{{ $epsodios }}"@endisset>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="capa" class="form-label">Capa</label>
            <input type="file" name="capa" name="capa" class="form-control" accept="image/gif, image/jpeg, image/png">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

