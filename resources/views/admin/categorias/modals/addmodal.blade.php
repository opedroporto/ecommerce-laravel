<span>

<input type="checkbox" id="addmodal" class="modal-checkbox">
<label for="addmodal" class="btn btn-add"><p><i class="fa-solid fa-plus"></i> <span>Nova Categoria</span></p></label>

<label for="addmodal" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="addmodal"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.categorias.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Nova Categoria</h1>
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
            <label>Nome:</label>
            <input class="{{ ($errors->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ old('nome') }}" required>
            <p class="error-msg">{{ $errors->first('nome') ? $errors->first('nome') : "" }}</p>
        </div>

        <div>
            <label>Descrição:</label>
            <textarea class="{{ ($errors->first('descricao') ? "input-error" : "") }}" name="descricao" rows="3">{{ old('descricao') }}</textarea>
            <p class="error-msg">{{ $errors->first('descricao') ? $errors->first('descricao') : "" }}</p>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar nova categoria</button>
        </div>
    </form>
</div>

</span>