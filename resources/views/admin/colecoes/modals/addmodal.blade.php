<span>

<input type="checkbox" id="addmodal" class="modal-checkbox">
<label for="addmodal" class="btn btn-add"><p><i class="fa-solid fa-plus"></i> <span>Nova coleção</span></p></label>

<label for="addmodal" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="addmodal"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.colecoes.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Nova Decoração</h1>
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

        <div>
            <label>Imagem:</label>
            
            <div class="file-upload">
                <div class="image-upload-wrap">
                    <input class="file-upload-input {{ ($errors->first('img') ? "input-error" : "") }}" type='file' name="img" onchange="readURL(this);" accept="image/*" required>
                    <div class="drag-text">
                        <i class="fa-regular fa-images fa-2xl"></i>
                        <h3>
                        Arraste e solte uma imagem <br>
                        ou
                        clique para carregar uma
                        </h3>
                    </div>
                </div>
                <div class="file-upload-content">
                    <img class="file-upload-image" src="#" alt="Imagem carregada" />
                    <div class="image-title-wrap">
                    <button type="button" onclick="removeUpload(this)" class="remove-image">Remover <span class="image-title">Imagem carregada</span></button>
                    </div>
                </div>
            </div>
            <p class="error-msg">{{ $errors->first('img') ? $errors->first('img') : "" }}</p>
        </div>

        <div>
            <label>Preço:</label>
            <input class="nospinbox {{ ($errors->first('valor') ? "input-error" : "") }}" type="number" name="valor" value="{{ old('valor') }}" min="0" step="0.01" required>
            <p class="error-msg">{{ $errors->first('valor') ? $errors->first('valor') : "" }}</p>
        </div>

        <div>
            <label>Quantidade:</label>
            <input class="{{ ($errors->first('quantidade') ? "input-error" : "") }}" type="number" name="quantidade" value="{{ old('quantidade') }}" min="0" step="1" required>
            <p class="error-msg">{{ $errors->first('quantidade') ? $errors->first('quantidade') : "" }}</p>
        </div>

        <div class="select-wrapper">
            <label>Produtos:</label>
            <div class="select-rows">
                <div class="select-row">
                    <select class="select-select" name="produtos[0][id]">
                        @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                        @endforeach
                    </select>
                    <input class="select-input" type="number" name="produtos[0][quantidade]" value="1" min="1" step="1" required>
                    <button class="select-remove" style="visibility: hidden;" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <button class="select-add" type="button" onclick="appendSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar nova coleção</button>
        </div>
    </form>
</div>

</span>

@push("scripts")



@endpush