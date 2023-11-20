<span>

<input type="checkbox" id="deletemanymodal" class="modal-checkbox">
{{-- <label for="modal" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></label> --}}
<label for="deletemanymodal" class="btn btn-delete"><p><i class="fa-solid fa-trash"></i> <span>Deletar</span></p></label>

<label for="deletemanymodal" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="deletemanymodal"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.categorias.deletemany") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="ids">
        </div>
        <h1 id="modal-title">Deletar todas as categorias selecionados <br> permanentemente?</h1>
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
                <label for="deletemanymodal" class="modal-btn modal-cancel-btn">
                    Cancelar
                </label>
                <button class="modal-btn modal-delete-btn" type="submit">Deletar</button>
            </div>
        </div>
    </form>
</div>

</span>

@push('scripts')

<script>
    var checked_rows = false;
    $(".row-checkbox").change(function() {
        $("#ids").empty();

        let any_checked_row = false;
        $(".row-checkbox").each(function() {
            if ($(this).is(":checked")) {
                any_checked_row = true;

                $("<input>").attr({
                    type: "hidden",
                    name: "ids[]",
                    value: $(this).val()
                }).appendTo("#ids");
            };
        });
        checked_rows = any_checked_row;

    });

    $("#deletemanymodal").on("click", function(event) {
        if (!(checked_rows)) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });
</script>

@endpush