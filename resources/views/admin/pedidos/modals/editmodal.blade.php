<span>

<input type="checkbox" id="editmodal{{ $id }}" class="modal-checkbox">
{{-- <label for="editmodal{{ $id }}" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></label> --}}
<label for="editmodal{{ $id }}" class="edit" data-toggle="modal"><i class="fa-solid fa-pencil"></i></label>

<label for="editmodal{{ $id }}" class="modal-background"></label>

<div id="modal-popup-box" class="modal edit-modal">
    <div id="top-bar">
        <label for="editmodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.pedidos.edit") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Editar Pedido #{{ $id }}</h1>
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
            <label>Preço:</label>
            <input class="nospinbox {{ ($errors->first('valor') ? "input-error" : "") }}" type="number" name="valor" value="{{ $item->valor }}" min="0" step="0.01" required>
            <p class="error-msg">{{ $errors->first('valor') ? $errors->first('valor') : "" }}</p>
        </div>

        <div>
            <label>Data de INÍCIO do evento:</label>
            <input class="{{ ($errors->first('data') ? "input-error" : "") }}" type="date" name="data" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->data)->format('Y-m-d') }}" required>
            <p class="error-msg">{{ $errors->first('data') ? $errors->first('data') : "" }}</p>
        </div>
        <div>
            <label>Horário de INÍCIO (8h - 18h):</label>
            <input class="{{ ($errors->first('time') ? "input-error" : "") }}" type="time" name="time" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->data)->format('H:i') }}" min="08:00" max="18:00" required> 
            <p class="error-msg">{{ $errors->first('time') ? $errors->first('time') : "" }}</p>
        </div>
        <div>
            <label>Data de FIM do evento:</label>
            <input class="{{ ($errors->first('data2') ? "input-error" : "") }}" type="date" name="data2" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->data_fim)->format('Y-m-d') }}" required>
            <p class="error-msg">{{ $errors->first('data2') ? $errors->first('data2') : "" }}</p>
        </div>
        <div>
            <label>Horário de FIM (8h - 18h):</label>
            <input class="{{ ($errors->first('time2') ? "input-error" : "") }}" type="time" name="time2" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->data)->format('H:i') }}" min="08:00" max="18:00" required> 
            <p class="error-msg">{{ $errors->first('time2') ? $errors->first('time2') : "" }}</p> 
        </div>

        <div>
            <label>Modo (Entrega / Retirada):</label>
            <fieldset id="modo-fieldset{{ $item->id }}" class="modo-fieldset" required>
                <div class="modo-fieldset-item">
                    <input id="entrega" type="radio" value="entrega" name="modo" {{ $item->entrega ? "checked" : "" }}>
                    <label for="entrega">Entrega</label>
                </div>
                <div class="modo-fieldset-item">
                    <input id="retirada" type="radio" value="retirada" name="modo" {{ $item->retirada ? "checked" : "" }}>
                    <label for="retirada">Retirada</label>
                </div>
            </fieldset>
            <p class="error-msg">{{ $errors->first('modo') ? $errors->first('modo') : "" }}</p>
        </div>

        <div>
            <label>Taxa de entrega:</label>
            <input class="nospinbox {{ ($errors->first('taxa_entrega') ? "input-error" : "") }}" type="number" name="taxa_entrega" value="{{ $item->taxa_entrega }}" min="0" step="0.01">
            <p class="error-msg">{{ $errors->first('taxa_entrega') ? $errors->first('taxa_entrega') : "" }}</p>
        </div>

        <div>
            <label>Taxa de montagem:</label>
            <input class="nospinbox {{ ($errors->first('taxa_montagem') ? "input-error" : "") }}" type="number" name="taxa_montagem" value="{{ $item->taxa_montagem }}" min="0" step="0.01">
            <p class="error-msg">{{ $errors->first('taxa_montagem') ? $errors->first('taxa_montagem') : "" }}</p>
        </div>

        <div>
            <label>Observação:</label>
            <textarea id="observacao" class="{{ ($errors->first('observacao') ? "input-error" : "") }}" type="text" name="observacao" placeholder="" rows="2" cols="20">{{ $item->observacao }}</textarea>
            <p class="error-msg">{{ $errors->first('observacao') ? $errors->first('observacao') : "" }}</p>
        </div>

        <div>
            <label>URI de pagamento:</label>
            <input class="{{ ($errors->first('uri_pagamento') ? "input-error" : "") }}" type="text" name="uri_pagamento" value="{{ $item->uri_pagamento }}">
            <p class="error-msg">{{ $errors->first('uri_pagamento') ? $errors->first('uri_pagamento') : "" }}</p>
        </div>

        <div>
        <label>Status:</label>
            <select class="{{ ($errors->first('status') ? "input-error" : "") }}" name="status" required>
                @foreach ($statuses as $status)
                    @if ($status['value'] == $item->status)
                        <option value="{{ $status['value'] }}" selected="selected">{{ $status['name'] }}</option>
                    @else
                        <option value="{{ $status['value'] }}">{{ $status['name'] }}</option>
                    @endif
                @endforeach
            </select>
            <p class="error-msg">{{ $errors->first('status') ? $errors->first('status') : "" }}</p>
        </div>

        <div>
            <label>Forma de pagamento:</label>
            <select class="{{ ($errors->first('id_forma_de_pagamento') ? "input-error" : "") }}" name="id_forma_de_pagamento" required>
                @foreach ($formas_de_pagamento as $forma_de_pagamento)
                    @if ($forma_de_pagamento->id == $item->id_forma_de_pagamento)
                        <option value="{{ $forma_de_pagamento->alias }}" selected="selected">{{ $forma_de_pagamento->nome }}</option>
                    @else
                        <option value="{{ $forma_de_pagamento->alias }}">{{ $forma_de_pagamento->nome }}</option>
                    @endif
                @endforeach
            </select>
            <p class="error-msg">{{ $errors->first('id_forma_de_pagamento') ? $errors->first('id_forma_de_pagamento') : "" }}</p>
        </div>

        <div>
            <label>Endereço do pedido:</label>
            <select class="{{ ($errors->first('id_endereco') ? "input-error" : "") }}" name="id_endereco" required>
                @foreach ($enderecos as $endereco)
                    @if ($endereco->id == $item->id_endereco)
                        <option value="{{ $endereco->id }}" selected="selected">{{ format_endereco($endereco) }}</option>
                    @else
                        <option value="{{ $endereco->id }}">{{ format_endereco($endereco) }}</option>
                    @endif
                @endforeach
            </select>
            <p class="error-msg">{{ $errors->first('id_endereco') ? $errors->first('id_endereco') : "" }}</p>
        </div>

        <div>
            <label>Usuário do pedido:</label>
            <select class="{{ ($errors->first('id_usuario') ? "input-error" : "") }}" name="id_usuario" required>
                @foreach ($usuarios as $usuario)
                    @if ($usuario->id == $item->id_usuario)
                        <option value="{{ $usuario->id }}" selected="selected">{{ "(" . (string)$usuario->id . ") " . (string)$usuario->nome }}</option>
                    @else
                        <option value="{{ $usuario->id }}">{{ "(" . (string)$usuario->id . ") " . (string)$usuario->nome }}</option>
                    @endif
                @endforeach
            </select>
            <p class="error-msg">{{ $errors->first('id_usuario') ? $errors->first('id_usuario') : "" }}</p>
        </div>

        {{-- <div>
            <label>Itens do pedido <span class="light-text">(não modificável)</span>:</label>
            @foreach ($item->items_pedido as $item_pedido)
            <div class="stage-details-item">
                <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
            </div>
            @endforeach
        </div> --}}

        <div id="select-wrapper1" class="select-wrapper">
            <label>Produtos:</label>
            <div class="select-rows">

                @php $i = 0 @endphp
                @foreach ($item->items_pedido as $produto_item)
                    @if ($produto_item->tipo == "produto")
                        <div class="select-row">
                            <select class="select-select" name="produtos[{{ $i }}][id]">
                                @foreach ($produtos as $produto)
                                    @if ($produto_item->id_produto == $produto->id)
                                        <option value="{{ $produto->id }}" selected>{{ $produto->nome }}</option>
                                    @else
                                        <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input class="select-input" type="number" name="produtos[{{ $i }}][quantidade]" value="{{ $produto_item->quantidade }}" min="1" step="1" required>
                            <button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @php $i++ @endphp
                    @endif
                @endforeach

            </div>
            <button class="select-add" type="button" onclick="appendProdutoSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>

        <div id="select-wrapper2" class="select-wrapper">
            <label>Coleções:</label>
            <div class="select-rows">

                @php $i = 0 @endphp
                @foreach ($item->items_pedido as $colecao_item)
                    @if ($colecao_item->tipo == "colecao")
                        <div class="select-row">
                            <select class="select-select" name="colecoes[{{ $i }}][id]">
                                @foreach ($colecoes as $colecao)
                                    @if ($colecao_item->id_produto == $colecao->id)
                                        <option value="{{ $colecao->id }}" selected>{{ $colecao->nome }}</option>
                                    @else
                                        <option value="{{ $colecao->id }}">{{ $colecao->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input class="select-input" type="number" name="colecoes[{{ $i }}][quantidade]" value="{{ $colecao_item->quantidade }}" min="1" step="1" required>
                            <button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @php $i++ @endphp
                    @endif
                @endforeach

            </div>
            <button class="select-add" type="button" onclick="appendColecaoSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Editar pedido</button>
        </div>
    </form>
</div>

</span>

@push("scripts")

<script src="{{ asset("js/jquery/jquery.inputmask.min.js") }}"></script>
<script>

    $("#refresh{{ $id }}").on("click", function() {
        let edit_modal_el = $(this).closest(".edit-modal");

        $($(edit_modal_el).find("[name='valor']")).val("{{ $item->valor }}");
        $($(edit_modal_el).find("[name='data']")).val("{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->data)->format('Y-m-d') }}");
        $($($("#modo-fieldset{{ $item->id }}")).find("[value='{{ $item->entrega ? "entrega" : "retirada" }}']")).prop("checked", true);
        $($(edit_modal_el).find("[name='taxa_entrega']")).val("{{ $item->taxa_entrega }}");
        $($(edit_modal_el).find("[name='taxa_montagem']")).val("{{ $item->taxa_montagem }}");
        $($(edit_modal_el).find("[name='observacao']")).val("{{ $item->observacao }}");
        $($(edit_modal_el).find("[name='uri_pagamento']")).val("{{ $item->uri_pagamento }}");
        $($(edit_modal_el).find("[name='pago']")).prop("checked", {{ $item->pago ? "true" : "false" }});
        $($(edit_modal_el).find("[name='id_forma_de_pagamento']")).val("{{ $item->forma_de_pagamento->alias }}").change();
        $($(edit_modal_el).find("[name='id_endereco']")).val("{{ $item->id_endereco }}").change();
        $($(edit_modal_el).find("[name='id_usuario']")).val("{{ $item->id_usuario }}").change();
        $("#select-wrapper1").replaceWith(`
            <div id="select-wrapper1" class="select-wrapper">
            <label>Produtos:</label>
            <div class="select-rows">

                @foreach ($item->items_pedido as $produto_item)
                    @if ($produto_item->tipo == "produto")
                        <div class="select-row">
                            <select class="select-select" name="produtos[{{ $loop->index }}][id]">
                                @foreach ($produtos as $produto)
                                    @if ($produto_item->id_produto == $produto->id)
                                        <option value="{{ $produto->id_produto }}" selected>{{ $produto->nome }}</option>
                                    @else
                                        <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input class="select-input" type="number" name="produtos[{{ $loop->index }}][quantidade]" value="{{ $produto_item->quantidade }}" min="1" step="1" required>
                            <button class="select-remove" style="visibility: hidden;" onclick="removeProdutoSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    @endif
                @endforeach

            </div>
            <button class="select-add" type="button" onclick="appendProdutoSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>`
        );

        $("#select-wrapper2").replaceWith(`
            <div id="select-wrapper2" class="select-wrapper">
            <label>Coleções:</label>
            <div class="select-rows">

                @foreach ($item->items_pedido as $colecao_item)
                    @if ($colecao_item->tipo == "colecao")
                        <div class="select-row">
                            <select class="select-select" name="colecoes[{{ $loop->index }}][id]">
                                @foreach ($colecoes as $colecao)
                                    @if ($colecao_item->id_produto == $colecao->id)
                                        <option value="{{ $colecao->id }}" selected>{{ $colecao->nome }}</option>
                                    @else
                                        <option value="{{ $colecao->id }}">{{ $colecao->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input class="select-input" type="number" name="colecoes[{{ $loop->index }}][quantidade]" value="{{ $colecao_item->quantidade }}" min="1" step="1" required>
                            <button class="select-remove" style="visibility: hidden;" onclick="removeColecaoSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    @endif
                @endforeach

            </div>
            <button class="select-add" type="button" onclick="appendColecaoSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>`
        );
    });

    
</script>

@endpush
