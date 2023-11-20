@extends("site.layout")

@section("title", "Pedidos")

@push('styles')

<link rel="stylesheet" href="{{ asset("css/site/perfil.css") }}">

@endpush

@section("content")

<div class="container">
    <div id="modal-popup-form" class="info">
        <form class="form" action="{{ route("site.editusuario") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h1 class="info-title">Seus dados:</h1>
            <div class="action-group">
                <p id="refresh" class="refresh-btn"><i class="fa-solid fa-clock-rotate-left"></i> Informações originais</p>
                <button class="action-btn edit-btn" type="button"><i class="fa-solid fa-pencil fa-2x"></i></button>
                <button class="action-btn view-btn" type="button"><i class="fa-solid fa-eye fa-2x"></i></button>
            </div>
            {{-- @if ($errors->any())
                <div class="error-msg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            {{-- <input type="hidden" name="id" value="{{ $usuario->id }}" required> --}}
            
            <div>
                <label>Nome:</label>
                <input class="{{ ($errors->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ $usuario->nome }}" required disabled>
                <p class="error-msg">{{ $errors->first('nome') ? $errors->first('nome') : "" }}</p>
            </div>

            <div>
                <label>Sobrenome:</label>
                <input class="{{ ($errors->first('sobrenome') ? "input-error" : "") }}" type="text" name="sobrenome" value="{{ $usuario->sobrenome }}" required disabled>
                <p class="error-msg">{{ $errors->first('sobrenome') ? $errors->first('sobrenome') : "" }}</p>
            </div>

            <div>
                <label>E-mail:</label>
                <input class="{{ ($errors->first('email') ? "input-error" : "") }}" type="email" name="email" value="{{ $usuario->email }}" required disabled>
                <p class="error-msg">{{ $errors->first('email') ? $errors->first('email') : "" }}</p>
            </div>

            <div>
                <label>CPF:</label>
                <input id="cpf" class="{{ ($errors->first('cpf') ? "input-error" : "") }}" type="text" name="cpf" value="{{ $usuario->cpf }}" required disabled>
                <p class="error-msg">{{ $errors->first('cpf') ? $errors->first('cpf') : "" }}</p>
            </div>

            <div>
                <label>Telefone:</label>
                <input id="tel" class="{{ ($errors->first('telefone') ? "input-error" : "") }}" type="text" name="telefone" value="{{ $usuario->tel }}" required disabled>
                <p class="error-msg">{{ $errors->first('telefone') ? $errors->first('telefone') : "" }}</p>
            </div>

            <div>
                <label>Data de nascimento:</label>
                <input class="{{ ($errors->first('datanasc') ? "input-error" : "") }}" type="date" name="datanasc" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $usuario->dtnasc)->format('Y-m-d') }}" required disabled>
                <p class="error-msg">{{ $errors->first('datanasc') ? $errors->first('datanasc') : "" }}</p>
            </div>

            <div id="info-bottom">
                <button class="info-btn info-main-btn" type="submit">Editar</button>
            </div>
        </form>
    </div>
    <section id="endereco">
        <div class="info info-address">
            <h1 class="info-title">Seus endereços:</h1>

            <div id="address-rows" class="address-rows">

                @foreach ($enderecos as $endereco)
                    <div class="address-row">
                        <p>{{ format_endereco($endereco) }}</p>
                        @include("site.modals.editmodal", ["id" => $endereco->id, "item" => $endereco])
                        @include("site.modals.deletemodal", ["id" => $endereco->id])
                        {{-- <button class="address-btn address-remove" onclick="removeaddress(this)" style="visibility: hidden;"><i class="fa-solid fa-xmark"></i></button> --}}
                    </div>
                @endforeach

            </div>
            @include("site.modals.addmodal", ["id" => $endereco->id])
        </div>
    </section>
</div>

@endsection

@push('scripts')

<script src="{{ asset("js/jquery/jquery.inputmask.min.js") }}"></script>
<script>
    $("#cpf").inputmask("999.999.999-99");
    $("#tel").inputmask("(99) 99999-9999");

    $("#refresh").on("click", function() {
        restoreInfo();
    });

    function restoreInfo() {
        let edit_info_el = $(".info").closest(".info");

        $($(edit_info_el).find("[name='nome']")).val("{{ $usuario->nome }}");
        $($(edit_info_el).find("[name='sobrenome']")).val("{{ $usuario->sobrenome }}");
        $($(edit_info_el).find("[name='email']")).val("{{ $usuario->email }}");
        $($(edit_info_el).find("[name='cpf']")).val("{{ $usuario->cpf }}");
        $($(edit_info_el).find("[name='telefone']")).val("{{ $usuario->tel }}");
        $($(edit_info_el).find("[name='datanasc']")).val("{{ Carbon\Carbon::createFromFormat('Y-m-d', $usuario->dtnasc)->format('Y-m-d') }}");
    }

    $(".edit-btn").on("click", function() {
        $("#info-bottom").css("visibility", "visible");
        $("#refresh").css("visibility", "visible");
        $(".edit-btn").hide();
        $(".view-btn").show();

        $(".info input").prop('disabled', false);
        $(".info select").prop('disabled', false);
    })

    $(".view-btn").on("click", function() {
        $("#info-bottom").css("visibility", "hidden");
        $("#refresh").css("visibility", "hidden");
        $(".view-btn").hide();
        $(".edit-btn").show();

        $(".info input").prop('disabled', true);
        $(".info select").prop('disabled', true);
        restoreInfo();
    })

    function appendaddress(addBtn) {
        let rows_wrapper = $(addBtn.closest(".info-address")).find(".address-rows");
        console.log(rows_wrapper);
        let current_row_index = $(rows_wrapper).find(".address-row").length;
        $(rows_wrapper).append(`
            <div class="address-row">
                <p>{{ format_endereco($endereco) }}</p>
                @include("site.modals.editmodal", ["id" => $endereco->id, "item" => $endereco])
                @include("site.modals.deletemodal", ["id" => $endereco->id])
            </div>
        `);
        {{-- rows = $(rows_wrapper).find(".address-row");
        rows.each(function(i, row) {
            if (rows.length == 2 && i > 0 && !$(row).has(".address-remove").length) {
                $(row).append(`<button class="address-btn address-remove" onclick="removeaddress(this)"><i class="fa-solid fa-xmark"></i></button>`);
            }
        }); --}}
    }
    function removeaddress(btn) {
        $(btn).closest(".address-row").remove();
    }

    $("input[name=cep]").change(async function(e) {
        {{-- console.log($(e.target).val()); --}}
        {{-- let cep = $("input[name=cep]").val(); --}}
        let form =  $(e.target).closest(".form");
        let cep = $(e.target).val();

        if (cep.match(/^[0-9]{5}-[0-9]{3}$/)) {
            let url = "https://viacep.com.br/ws/" + cep + "/json/";
            let response = await fetch(url);
            let end = await response.json();

            if (!$(form).find("input[name=cidade]").val()) {
                $(form).find("input[name=cidade]").val(end["localidade"]);   
            }
            if (!$(form).find("input[name=bairro]").val()) {
                $(form).find("input[name=bairro]").val(end["bairro"]);   
            }
            if (!$(form).find("input[name=rua]").val()) {
                $(form).find("input[name=rua]").val(end["logradouro"]);   
            }
            if (!$(form).find("input[name=complemento]").val()) {
                $(form).find("input[name=complemento]").val(end["complemento"]);   
            }
            if (!$(form).find("select[name=uf]").val()) {
                $(form).find("select[name=uf]").val(end["uf"]);   
            }
        }
    });
    
</script>

@endpush