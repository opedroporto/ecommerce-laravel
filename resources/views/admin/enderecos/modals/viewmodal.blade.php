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
        <h1 id="modal-title">Visualizar endereço</h1>
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
            <label>CEP:</label>
            <input class="{{ ($errors->first('cep') ? "input-error" : "") }}" type="text" name="cep" value="{{ format_cep($item->cep) }}" required disabled>
            <p class="error-msg">{{ $errors->first('cep') ? $errors->first('cep') : "" }}</p>
        </div>

        <div>
            <label>Rua:</label>
            <input class="{{ ($errors->first('rua') ? "input-error" : "") }}" type="text" name="rua" maxlength="50" value="{{ $item->rua }}" required disabled>
            <p class="error-msg">{{ $errors->first('rua') ? $errors->first('rua') : "" }}</p>
        </div>

        <div>
            <label>Número:</label><br>
            <input class="{{ ($errors->first('num') ? "input-error" : "") }}" type="text" name="num" maxlength="5" value="{{ $item->num }}" required disabled>
            <p class="error-msg">{{ $errors->first('num') ? $errors->first('num') : "" }}</p>
        </div>

        <div>
            <label>Bairro:</label>
            <input class="{{ ($errors->first('bairro') ? "input-error" : "") }}" type="text" name="bairro" maxlength="50" value="{{ $item->bairro }}" required disabled>
            <p class="error-msg">{{ $errors->first('bairro') ? $errors->first('bairro') : "" }}</p>
        </div>

        <div>
            <label>Cidade:</label>
            <input class="{{ ($errors->first('cidade') ? "input-error" : "") }}" type="text" name="cidade" maxlength="50" value="{{ $item->cidade }}" required disabled>
            <p class="error-msg">{{ $errors->first('cidade') ? $errors->first('cidade') : "" }}</p>
        </div>

        <div>
            <label>UF:</label><br>
            <input class="{{ ($errors->first('uf') ? "input-error" : "") }}" list="uf-list" maxlength="2" name="uf" value="{{ $item->uf }}" required disabled>
            <p class="error-msg">{{ $errors->signup->first('uf') ? $errors->signup->first('uf') : "" }}</p>
        </div>

        <div>
            <label>Complemento:</label>
            <input class="{{ ($errors->first('complemento') ? "input-error" : "") }}" type="text" name="complemento" value="{{ $item->complemento }}" disabled>
            <p class="error-msg">{{ $errors->first('complemento') ? $errors->first('complemento') : "" }}</p>
        </div>

        <div>
            <label>Usuário:</label><br>

            <select class="{{ ($errors->first('id_usuario') ? "input-error" : "") }}" name="id_usuario" required disabled>
                @foreach ($usuarios as $usuario)
                    @if ($usuario->id == $item->id_usuario)
                        <option value="{{ $usuario->id }}" selected="selected">{{ $usuario->nome }}</option>
                    @else
                        <option value="{{ $usuario->id }}">{{ $usuario->nome }}</option>
                    @endif
                @endforeach
            </select>

            <p class="error-msg">{{ $errors->first('id_usuario') ? $errors->first('id_usuario') : "" }}</p>
        </div>

        {{-- <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo produto</button>
        </div> --}}
    </form>
</div>

</span>