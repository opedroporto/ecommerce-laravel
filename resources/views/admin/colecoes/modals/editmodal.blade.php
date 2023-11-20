@php
    $produto_colecao = $item->produto_colecao;
@endphp

<span>

<input type="checkbox" id="editmodal{{ $id }}" class="modal-checkbox">
{{-- <label for="editmodal{{ $id }}" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></label> --}}
<label for="editmodal{{ $id }}" class="edit" data-toggle="modal"><i class="fa-solid fa-pencil"></i></label>

<label for="editmodal{{ $id }}" class="modal-background"></label>

<div id="modal-popup-box" class="modal edit-modal">
    <div id="top-bar">
        <label for="editmodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.colecoes.edit") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Editar Decoração #{{ $id }}</h1>
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
            <label>Nome:</label>
            <input class="{{ ($errors->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ $item->nome }}" required>
            <p class="error-msg">{{ $errors->first('nome') ? $errors->first('nome') : "" }}</p>
        </div>

        <div>
            <label>Descrição:</label>
            <textarea class="{{ ($errors->first('descricao') ? "input-error" : "") }}" name="descricao" rows="3">{{ $item->descricao }}</textarea>
            {{-- <input class="{{ ($errors->first('descricao') ? "input-error" : "") }}" type="text" name="descricao" value="{{ old('descricao') }}" required> --}}
            <p class="error-msg">{{ $errors->first('descricao') ? $errors->first('descricao') : "" }}</p>
        </div>

        <div>
            <label>Imagem:</label>
            
            <div class="file-upload">
                {{-- <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button> --}}

                <div class="image-upload-wrap">
                    <input class="file-upload-input {{ ($errors->first('img') ? "input-error" : "") }}" type="file" name="img" onchange="readURL(this);" accept="image/*">
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
                    <img class="file-upload-image" src="{{ $item->img }}" alt="Imagem carregada" />
                    <div class="image-title-wrap">
                    <button type="button" onclick="removeUpload(this)" class="remove-image">Remover <span class="image-title">Imagem original</span></button>
                    </div>
                </div>
            </div>
            <p class="error-msg">{{ $errors->first('img') ? $errors->first('img') : "" }}</p>
        </div>
        
        <div>
            <label>Preço:</label>
            <input class="nospinbox {{ ($errors->first('valor') ? "input-error" : "") }}" type="number" name="valor" value="{{ $item->valor }}" min="0" step="0.01" required>
            <p class="error-msg">{{ $errors->first('valor') ? $errors->first('valor') : "" }}</p>
        </div>

        <div>
            <label>Quantidade:</label>
            <input class="{{ ($errors->first('quantidade') ? "input-error" : "") }}" type="number" name="quantidade" value="{{ $item->quantidade }}" min="0" step="1" required>
            <p class="error-msg">{{ $errors->first('quantidade') ? $errors->first('quantidade') : "" }}</p>
        </div>

        <div class="select-wrapper">
            <label>Produtos:</label>
            <div id="select-rows{{ $item->id }}" class="select-rows">

                @foreach ($produto_colecao as $produto_item)
                    <div class="select-row">
                        <select class="select-select" name="produtos[{{ $loop->index }}][id]">
                            @foreach ($produtos as $produto)
                                @if ($produto_item->id_produto == $produto->id)
                                    <option value="{{ $produto->id }}" selected>{{ $produto->nome }}</option>
                                @else
                                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                        <input class="select-input" type="number" name="produtos[{{ $loop->index }}][quantidade]" value="{{ $produto_item->quantidade }}" min="1" step="1" required>
                        @if ($loop->index == 0)
                            <button class="select-remove" style="visibility: hidden;" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        @else
                            <button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        @endif
                    </div>
                @endforeach

            </div>
            <button class="select-add" type="button" onclick="appendSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Editar decoração</button>
        </div>
    </form>
</div>

</span>

@push("scripts")

<script>

    function showImg() {
        $($(".edit-modal").find('.image-upload-wrap')).hide();
        $($(".edit-modal").find('.file-upload-content')).show();
    }
    showImg();

    $("#refresh{{ $id }}").on("click", function() {
        let edit_modal_el = $(this).closest(".edit-modal");

        $($(edit_modal_el).find("[name='nome']")).val("{{ $item->nome }}");
        $($(edit_modal_el).find("[name='descricao']")).val("{{ $item->descricao }}");
        $($(edit_modal_el).find(".file-upload-image")).attr("src", "{{ $item->img }}");
        $($(edit_modal_el).find(".file-upload-image")).attr("src", "{{ $item->img }}");
        $($(edit_modal_el).find(".file-upload-input")).val("");
        $($(edit_modal_el).find(".image-title")).text("Imagem original");
        showImg();
        $($(edit_modal_el).find("[name='valor']")).val("{{ $item->valor }}");
        $($(edit_modal_el).find("[name='quantidade']")).val("{{ $item->quantidade }}");

        $("#select-rows{{ $item->id }}").replaceWith(`
        <div id="select-rows{{ $item->id }}" class="select-rows">

                @foreach ($produto_colecao as $produto_item)
                    <div class="select-row">
                        <select class="select-select" name="produtos[{{ $loop->index }}][id]">
                            @foreach ($produtos as $produto)
                                @if ($produto_item->id_produto == $produto->id)
                                    <option value="{{ $produto->id }}" selected>{{ $produto->nome }}</option>
                                @else
                                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                        <input class="select-input" type="number" name="produtos[{{ $loop->index }}][quantidade]" value="{{ $produto_item->quantidade }}" min="1" step="1" required>
                        @if ($loop->index == 0)
                            <button class="select-remove" style="visibility: hidden;" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        @else
                            <button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        @endif
                    </div>
                @endforeach

            </div>`
        );
    });

    $(".file-upload-input").on("dragenter", function(event) {
        {{-- event.preventDefault();
        event.stopPropagation(); --}}
        let file_upload_el = $(this).closest(".file-upload");
        $(file_upload_el).find(".image-upload-wrap").addClass("file-dragover");
    });

    $(".file-upload-input").on("dragleave", function(event) {
        {{-- event.preventDefault();
        event.stopPropagation(); --}}
        let file_upload_el = $(this).closest(".file-upload");
        $(file_upload_el).find(".image-upload-wrap").removeClass("file-dragover");
    });


    function readURL(input) {
        let file_upload_el = $(input).closest(".file-upload");

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function(e) {
                $($(file_upload_el).find('.image-upload-wrap')).hide();

                $((file_upload_el).find('.file-upload-image')).attr('src', e.target.result);
                $((file_upload_el).find('.file-upload-content')).show();

                $((file_upload_el).find('.image-title')).html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);

        } else {
            console.log(input);
            removeUpload(input);
        }
    }

    function removeUpload(input) {
        console.log(input);
        let file_upload_el = $(input).closest(".file-upload");

        $($(file_upload_el).find('.file-upload-input')).replaceWith($($(file_upload_el).find('.file-upload-input')).clone());
        $($(file_upload_el).find('.file-upload-content')).hide();
        $($(file_upload_el).find('.image-upload-wrap')).show();
    }
    
</script>

@endpush
