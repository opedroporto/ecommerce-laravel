<span>

<link rel="stylesheet" href="{{ asset("css/admin/produto/popup.css") }}">

<input type="checkbox" id="deletemodal{{ $id }}" class="modal-checkbox">
{{-- <label for="modal" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></label> --}}
<label for="deletemodal{{ $id }}" class="delete"><i class="fa-solid fa-trash"></i></label>

<label for="deletemodal{{ $id }}" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="deletemodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.produtos.delete") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" type="text" value="{{ $id }}" name="id">
        <h1 id="modal-title">Deletar o produto #{{ $id }} <br> permanentemente?</h1>
        {{-- @if ($errors->any())
            <div class="error-msg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <p class="modal-flash-msg">Essa ação é irreversível!</p>

        <div id="modal-bottom">
            <div class="modal-bottom-btns">
                <label for="deletemodal{{ $id }}" class="modal-btn modal-cancel-btn">
                    Cancelar
                </label>
                <button class="modal-btn modal-delete-btn" type="submit">Deletar</button>
            </div>
        </div>
    </form>
</div>

</span