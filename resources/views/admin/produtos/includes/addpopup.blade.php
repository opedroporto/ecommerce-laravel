<span>

<link rel="stylesheet" href="{{ asset("css/admin/produto/popup.css") }}">

<input type="checkbox" id="addmodal" class="modal-checkbox">
<label for="addmodal" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></label>

<label for="addmodal" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="addmodal"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.produtos.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Novo Produto</h1>
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
            <textarea class="{{ ($errors->first('descricao') ? "input-error" : "") }}" name="descricao" rows="3" required>{{ old('descricao') }}</textarea>
            {{-- <input class="{{ ($errors->first('descricao') ? "input-error" : "") }}" type="text" name="descricao" value="{{ old('descricao') }}" required> --}}
            <p class="error-msg">{{ $errors->first('descricao') ? $errors->first('descricao') : "" }}</p>
        </div>

        <div>
            <label>Imagem:</label>
            
            <div class="file-upload">
                {{-- <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button> --}}

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

        <div>
            <label>Categoria:</label><br>
            <select class="{{ ($errors->first('categoria') ? "input-error" : "") }}" name="categoria" required>
                @foreach ($categorias as $categoria)
                    @if ($categoria->id == old("categoria"))
                        <option value="{{ $categoria->id }}" selected="selected">{{ $categoria->nome }}</option>
                    @else
                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                    @endif
                @endforeach
            </select>
            <p class="error-msg">{{ $errors->first('categoria') ? $errors->first('categoria') : "" }}</p>
            <p class="modal-bottom-msg">Categoria não existente? <wbr> <a id="signin-btn">Criar</a></p>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo produto</button>
        </div>
    </form>
</div>

</span>