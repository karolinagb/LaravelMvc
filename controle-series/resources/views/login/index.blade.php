<x-layout title="Login" class="mt-2">

<form method="post">
    @csrf

    <div class="form-group">
        <label for=email class="form-label">E-mail</label>
        <input type="email" name="email" id="email" class="form-control"/>
    </div>

    <div class="form-group">
        <label for=senha class="form-label">Senha</label>
        <input type="password" name="senha" id="senha" class="form-control"/>
    </div>

    <button class="btn btn-primary mt-3">
        Entrar
    </button>
</form>

</x-layout>
