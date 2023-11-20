<span>

<input type="checkbox" id="editmodal{{ $id }}" class="modal-checkbox">
{{-- <label for="editmodal{{ $id }}" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></label> --}}
<label for="editmodal{{ $id }}" class="edit" data-toggle="modal"><i class="fa-solid fa-pencil"></i></label>

<label for="editmodal{{ $id }}" class="modal-background"></label>

<div id="modal-popup-box" class="modal edit-modal">
    <div id="top-bar">
        <label for="editmodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.categorias.edit") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Editar Categoria #{{ $id }}</h1>
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

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Editar coleção</button>
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
    });
    
</script>

@endpush
