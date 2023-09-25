<span>

<input type="checkbox" id="addmodal" class="modal-checkbox">
<label for="addmodal" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo usuário</span></label>

<label for="addmodal" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="addmodal"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.usuarios.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Novo Usuário</h1>
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
            <select class="{{ ($errors->first('cargo') ? "input-error" : "") }}" name="cargo" required>
                <option value="0" selected="selected">Usuário</option>
                <option value="1">Administrador</option>
            </select>
            <p class="error-msg">{{ $errors->first('cargo') ? $errors->first('cargo') : "" }}</p>
        </div>
        
        <div>
            <label>Nome:</label>
            <input class="{{ ($errors->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ old('nome') }}" required>
            <p class="error-msg">{{ $errors->first('nome') ? $errors->first('nome') : "" }}</p>
        </div>

        <div>
            <label>Sobrenome:</label>
            <input class="{{ ($errors->first('sobrenome') ? "input-error" : "") }}" type="text" name="sobrenome" value="{{ old('sobrenome') }}" required>
            <p class="error-msg">{{ $errors->first('sobrenome') ? $errors->first('sobrenome') : "" }}</p>
        </div>

        <div>
            <label>Senha:</label>
            <input class="{{ ($errors->first('senha') ? "input-error" : "") }}" type="password" name="senha" value="{{ old('senha') }}" required>
            <p class="error-msg">{{ $errors->first('senha') ? $errors->first('senha') : "" }}</p>
        </div>

        <div>
            <label>E-mail:</label>
            <input class="{{ ($errors->first('email') ? "input-error" : "") }}" type="email" name="email" value="{{ old('email') }}" required>
            <p class="error-msg">{{ $errors->first('email') ? $errors->first('email') : "" }}</p>
        </div>

        <div>
            <label>CPF:</label>
            <input id="cpf" class="{{ ($errors->first('cpf') ? "input-error" : "") }}" type="text" name="cpf" value="{{ old('cpf') }}" required>
            <p class="error-msg">{{ $errors->first('cpf') ? $errors->first('cpf') : "" }}</p>
        </div>

        <div>
            <label>Telefone:</label>
            <input id="tel" class="{{ ($errors->first('telefone') ? "input-error" : "") }}" type="text" name="telefone" value="{{ old('telefone') }}" required>
            <p class="error-msg">{{ $errors->first('telefone') ? $errors->first('telefone') : "" }}</p>
        </div>

        <div>
            <label>Data de nascimento:</label>
            <input class="{{ ($errors->first('datanasc') ? "input-error" : "") }}" type="date" name="datanasc" value="{{ old('datanasc') }}" required>
            <p class="error-msg">{{ $errors->first('datanasc') ? $errors->first('datanasc') : "" }}</p>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo usuário</button>
        </div>
    </form>
</div>

</span>