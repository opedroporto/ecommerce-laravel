<span>

<input type="checkbox" id="viewmodal{{ $id }}" class="modal-checkbox">
<label for="viewmodal{{ $id }}" class="view"><i class="fa-solid fa-eye"></i></label>

<label for="viewmodal{{ $id }}" class="modal-background"></label>
<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="viewmodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.produtos.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Visualizar produto</h1>
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
            <input class="{{ ($errors->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ $item->nome }}" required disabled>
            <p class="error-msg">{{ $errors->first('nome') ? $errors->first('nome') : "" }}</p>
        </div>

        <div>
            <label>Descrição:</label>
            <textarea class="{{ ($errors->first('descricao') ? "input-error" : "") }}" name="descricao" rows="3" required disabled>{{ $item->descricao }}</textarea>
            {{-- <input class="{{ ($errors->first('descricao') ? "input-error" : "") }}" type="text" name="descricao" value="{{ old('descricao') }}" required> --}}
            <p class="error-msg">{{ $errors->first('descricao') ? $errors->first('descricao') : "" }}</p>
        </div>

        <div>
            <label>Imagem:</label>
            
            <div class="file-upload">
                {{-- <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button> --}}

                {{-- <div class="image-upload-wrap">
                    <input class="file-upload-input {{ ($errors->first('img') ? "input-error" : "") }}" type='file' name="img" onchange="readURL(this);" value="{{ old('img') }}" accept="image/*" required disabled>
                    <div class="drag-text">
                        <i class="fa-regular fa-images fa-2xl"></i>
                        <h3>
                        Arraste e solte uma imagem <br>
                        ou
                        clique para carregar uma
                        </h3>
                    </div>
                </div> --}}
                <div class="file-upload-content show-img">
                    <img class="file-upload-image" src="{{ $item->img }}" alt="Imagem carregada" />
                    {{-- <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload(this)" class="remove-image">Remover <span class="image-title">Imagem carregada</span></button>
                    </div> --}}
                </div>
            </div>
            <p class="error-msg">{{ $errors->first('img') ? $errors->first('img') : "" }}</p>
        </div>
        
        <div>
            <label>Preço:</label>
            <input class="nospinbox {{ ($errors->first('valor') ? "input-error" : "") }}" type="number" name="valor" value="{{ $item->valor }}" min="0" step="0.01" required disabled>
            <p class="error-msg">{{ $errors->first('valor') ? $errors->first('valor') : "" }}</p>
        </div>

        <div>
            <label>Quantidade:</label>
            <input class="nospinbox {{ ($errors->first('quantidade') ? "input-error" : "") }}" type="number" name="quantidade" value="{{ $item->quantidade }}" min="0" step="1" required disabled>
            <p class="error-msg">{{ $errors->first('quantidade') ? $errors->first('quantidade') : "" }}</p>
        </div>

        {{-- <div>
            <label>Produtos:</label>
            @foreach ($item->produtos as $produto)
                {{ $produto->id }}: {{ $produto->nome }} ( {{ Str::limit($produto->categoria->nome, 10) }} )<br>
            @endforeach
        </div> --}}
        <div class="select-wrapper">
            <label>Produtos:</label>
            <div class="select-rows">

                @foreach ($item->produto_colecao as $produto_item)
                    <div class="select-row">
                        <select class="select-select" name="produtos" disabled>
                            @foreach ($produtos as $produto)
                                @if ($produto_item->id_produto == $produto->id)
                                    <option value="{{ $produto->id }}" selected>{{ $produto->nome }}</option>
                                @else
                                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                        <input class="nospinbox select-input" type="number" name="quantidade" value="{{ $produto_item->quantidade }}" min="1" step="1" disabled>
                    </div>
                @endforeach

            </div>
            {{-- <button class="select-add" type="button" onclick="appendSelect()"><i class="fa-solid fa-plus"></i></button> --}}
        </div>

        {{-- <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo produto</button>
        </div> --}}
    </form>
</div>

</span>