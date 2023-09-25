<span>

<input type="checkbox" id="viewmodal{{ $id }}" class="modal-checkbox">
<label for="viewmodal{{ $id }}" class="view"><i class="fa-solid fa-eye"></i></label>

<label for="viewmodal{{ $id }}" class="modal-background"></label>
<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="viewmodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.usuarios.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Visualizar usuário</h1>
        {{-- @if ($errors->any())
            <div class="error-msg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div>
            <label>Cargo:</label>
            <input class="{{ ($errors->first('role') ? "input-error" : "") }}" type="text" name="role" value="{{ usuarioRole($item->role) }}" required disabled>
            <p class="error-msg">{{ $errors->first('role') ? $errors->first('role') : "" }}</p>
        </div>

        <div>
            <label>Nome:</label>
            <input class="{{ ($errors->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ $item->nome }}" required disabled>
            <p class="error-msg">{{ $errors->first('nome') ? $errors->first('nome') : "" }}</p>
        </div>

        <div>
            <label>Sobrenome:</label>
            <input class="{{ ($errors->first('sobrenome') ? "input-error" : "") }}" type="text" name="sobrenome" value="{{ $item->sobrenome }}" required disabled>
            <p class="error-msg">{{ $errors->first('sobrenome') ? $errors->first('sobrenome') : "" }}</p>
        </div>

        <div>
            <label>E-mail:</label>
            <input class="{{ ($errors->first('email') ? "input-error" : "") }}" type="email" name="email" value="{{ $item->email }}" required disabled>
            <p class="error-msg">{{ $errors->first('email') ? $errors->first('email') : "" }}</p>
        </div>

        <div>
            <label>CPF:</label>
            <input class="{{ ($errors->first('cpf') ? "input-error" : "") }}" type="text" name="cpf" value="{{ $item->cpf }}" required disabled>
            <p class="error-msg">{{ $errors->first('cpf') ? $errors->first('cpf') : "" }}</p>
        </div>

        <div>
            <label>Telefone:</label>
            <input class="{{ ($errors->first('telefone') ? "input-error" : "") }}" type="text" name="telefone" value="{{ $item->tel }}" required disabled>
            <p class="error-msg">{{ $errors->first('telefone') ? $errors->first('telefone') : "" }}</p>
        </div>

        <div>
            <label>Data de nascimento:</label>
            <input class="{{ ($errors->first('datanasc') ? "input-error" : "") }}" type="date" name="datanasc" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->dtnasc)->format('Y-m-d') }}" required disabled>
            <p class="error-msg">{{ $errors->first('datanasc') ? $errors->first('datanasc') : "" }}</p>
        </div>

        {{-- <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo produto</button>
        </div> --}}
    </form>
</div>

</span>