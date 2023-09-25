<span>

<input type="checkbox" id="editmodal{{ $id }}" class="modal-checkbox">
{{-- <label for="editmodal{{ $id }}" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></label> --}}
<label for="editmodal{{ $id }}" class="edit" data-toggle="modal"><i class="fa-solid fa-pencil"></i></label>

<label for="editmodal{{ $id }}" class="modal-background"></label>

<div id="modal-popup-box" class="modal edit-modal">
    <div id="top-bar">
        <label for="editmodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.usuarios.edit") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Editar Usuário #{{ $id }}</h1>
        <div>
            <p id="refresh{{ $id }}" class="refresh-btn"><i class="fa-solid fa-clock-rotate-left"></i> Informações originais</p>
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
        <input type="hidden" name="id" value="{{ $item->id }}" required>

        <div>
            <label>Cargo:</label>
            <select class="{{ ($errors->first('cargo') ? "input-error" : "") }}" name="cargo" required>
                @if ($item->role == 0)
                    <option value="0" selected="selected">Usuário</option>
                @else
                    <option value="0">Administrador</option>
                @endif

                @if ($item->role == 1)
                    <option value="1"selected="selected">Administrador</option>
                @else
                    <option value="1">Administrador</option>
                @endif
            </select>
            <p class="error-msg">{{ $errors->first('cargo') ? $errors->first('cargo') : "" }}</p>
        </div>
        
        <div>
            <label>Nome:</label>
            <input class="{{ ($errors->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ $item->nome }}" required>
            <p class="error-msg">{{ $errors->first('nome') ? $errors->first('nome') : "" }}</p>
        </div>

        <div>
            <label>Sobrenome:</label>
            <input class="{{ ($errors->first('sobrenome') ? "input-error" : "") }}" type="text" name="sobrenome" value="{{ $item->sobrenome }}" required>
            <p class="error-msg">{{ $errors->first('sobrenome') ? $errors->first('sobrenome') : "" }}</p>
        </div>

        <div>
            <label>E-mail:</label>
            <input class="{{ ($errors->first('email') ? "input-error" : "") }}" type="email" name="email" value="{{ $item->email }}" required>
            <p class="error-msg">{{ $errors->first('email') ? $errors->first('email') : "" }}</p>
        </div>

        <div>
            <label>CPF:</label>
            <input id="cpf" class="{{ ($errors->first('cpf') ? "input-error" : "") }}" type="text" name="cpf" value="{{ $item->cpf }}" required>
            <p class="error-msg">{{ $errors->first('cpf') ? $errors->first('cpf') : "" }}</p>
        </div>

        <div>
            <label>Telefone:</label>
            <input id="tel" class="{{ ($errors->first('telefone') ? "input-error" : "") }}" type="text" name="telefone" value="{{ $item->tel }}" required>
            <p class="error-msg">{{ $errors->first('telefone') ? $errors->first('telefone') : "" }}</p>
        </div>

        <div>
            <label>Data de nascimento:</label>
            <input class="{{ ($errors->first('datanasc') ? "input-error" : "") }}" type="date" name="datanasc" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->dtnasc)->format('Y-m-d') }}" required>
            <p class="error-msg">{{ $errors->first('datanasc') ? $errors->first('datanasc') : "" }}</p>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Editar usuáiro</button>
        </div>
    </form>
</div>

</span>

@push("scripts")

<script src="{{ asset("js/jquery/jquery.inputmask.min.js") }}"></script>
<script>
    $("#cpf").inputmask("999.999.999-99");
    $("#tel").inputmask("(99) 99999-9999");

    $("#refresh{{ $id }}").on("click", function() {
        let edit_modal_el = $(this).closest(".edit-modal");

        $($(edit_modal_el).find("[name='cargo']")).val("{{ $item->role }}");
        $($(edit_modal_el).find("[name='nome']")).val("{{ $item->nome }}");
        $($(edit_modal_el).find("[name='sobrenome']")).val("{{ $item->sobrenome }}");
        $($(edit_modal_el).find("[name='email']")).val("{{ $item->email }}");
        $($(edit_modal_el).find("[name='cpf']")).val("{{ $item->cpf }}");
        $($(edit_modal_el).find("[name='telefone']")).val("{{ $item->tel }}");
        $($(edit_modal_el).find("[name='datanasc']")).val("{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->dtnasc)->format('Y-m-d') }}");
    });

    
</script>

@endpush
