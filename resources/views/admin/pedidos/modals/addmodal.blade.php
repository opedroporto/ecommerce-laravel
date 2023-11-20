<span>

<input type="checkbox" id="addmodal" class="modal-checkbox">
<label for="addmodal" class="btn btn-add"><p><i class="fa-solid fa-plus"></i> <span>Novo pedido</span></p></label>

<label for="addmodal" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="addmodal"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.pedidos.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Novo Pedido</h1>
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
            <label>Preço:</label>
            <input class="nospinbox {{ ($errors->first('valor') ? "input-error" : "") }}" type="number" name="valor" value="{{ old("valor") }}" min="0" step="0.01" required>
            <p class="error-msg">{{ $errors->first('valor') ? $errors->first('valor') : "" }}</p>
        </div>

        <div>
            <label>Data do evento:</label>
            <input class="{{ ($errors->first('data') ? "input-error" : "") }}" type="date" name="data" value="{{ old("data") }}" required>
            <p class="error-msg">{{ $errors->first('data') ? $errors->first('data') : "" }}</p>
        </div>

        <div>
            <label>Data de INÍCIO do evento:</label>
            <input class="{{ ($errors->first('data') ? "input-error" : "") }}" type="date" name="data" required>
            <p class="error-msg">{{ $errors->first('data') ? $errors->first('data') : "" }}</p>
        </div>
        <div>
            <label>Horário de INÍCIO (8h - 18h):</label>
            <input class="{{ ($errors->first('time') ? "input-error" : "") }}" type="time" name="time" min="08:00" max="18:00" required> 
            <p class="error-msg">{{ $errors->first('time') ? $errors->first('time') : "" }}</p>
        </div>
        <div>
            <label>Data de FIM do evento:</label>
            <input class="{{ ($errors->first('data2') ? "input-error" : "") }}" type="date" name="data2" required>
            <p class="error-msg">{{ $errors->first('data2') ? $errors->first('data2') : "" }}</p>
        </div>
        <div>
            <label>Horário de FIM (8h - 18h):</label>
            <input class="{{ ($errors->first('time2') ? "input-error" : "") }}" type="time" name="time2" min="08:00" max="18:00" required> 
            <p class="error-msg">{{ $errors->first('time2') ? $errors->first('time2') : "" }}</p> 
        </div>

        <div>
            <label>Modo (Entrega / Retirada):</label>
            <fieldset class="modo-fieldset" required>
                <div class="modo-fieldset-item">
                    <input id="entrega" type="radio" value="entrega" name="modo" {{ old("modo") == "entrega" ? "checked" : "" }}>
                    <label for="entrega">Entrega</label>
                </div>
                <div class="modo-fieldset-item">
                    <input id="retirada" type="radio" value="retirada" name="modo" {{ old("modo") == "retirada" ? "checked" : "" }}>
                    <label for="retirada">Retirada</label>
                </div>
            </fieldset>
            <p class="error-msg">{{ $errors->first('modo') ? $errors->first('modo') : "" }}</p>
        </div>

        <div>
            <label>Taxa de entrega:</label>
            <input class="nospinbox {{ ($errors->first('taxa_entrega') ? "input-error" : "") }}" type="number" name="taxa_entrega" value="{{ old("taxa_entrega") }}" min="0" step="0.01">
            <p class="error-msg">{{ $errors->first('taxa_entrega') ? $errors->first('taxa_entrega') : "" }}</p>
        </div>

        <div>
            <label>Taxa de montagem:</label>
            <input class="nospinbox {{ ($errors->first('taxa_montagem') ? "input-error" : "") }}" type="number" name="taxa_montagem" value="{{ old("taxa_montagem") }}" min="0" step="0.01">
            <p class="error-msg">{{ $errors->first('taxa_montagem') ? $errors->first('taxa_montagem') : "" }}</p>
        </div>

        <div>
            <label>Observação:</label>
            <textarea id="observacao" class="{{ ($errors->first('observacao') ? "input-error" : "") }}" type="text" name="observacao" placeholder="" rows="2" cols="20">{{ old("observacao") }}</textarea>
            <p class="error-msg">{{ $errors->first('observacao') ? $errors->first('observacao') : "" }}</p>
        </div>

        <div>
            <label>URI de pagamento:</label>
            <input class="{{ ($errors->first('uri_pagamento') ? "input-error" : "") }}" type="text" name="uri_pagamento" value="{{ old("uri_pagamento") }}">
            <p class="error-msg">{{ $errors->first('uri_pagamento') ? $errors->first('uri_pagamento') : "" }}</p>
        </div>

        <div>
            <label>Status:</label>
            <select class="{{ ($errors->first('status') ? "input-error" : "") }}" name="status" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status['value'] }}">{{ $status['name'] }}</option>
                @endforeach
            </select>
            <p class="error-msg">{{ $errors->first('status') ? $errors->first('status') : "" }}</p>
        </div>

        <div>
            <label>Forma de pagamento:</label>
            <select class="{{ ($errors->first('id_forma_de_pagamento') ? "input-error" : "") }}" name="id_forma_de_pagamento" required>
                @foreach ($formas_de_pagamento as $forma_de_pagamento)
                    @if ($forma_de_pagamento->id == old("forma_de_pagamento"))
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
                    @if ($endereco->id == old("id_endereco"))
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
                    @if ($usuario->id == old("id_usuario"))
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
            @if (old("items_pedido"))
                @foreach (old("items_pedido") as $item_pedido)
                <div class="stage-details-item">
                    <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                    <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
                </div>
                @endforeach
            @endif
        </div> --}}
        <div class="select-wrapper">
            <label>Produtos:</label>
            <div class="select-rows">

                @if (old("items_pedido"))
                    @foreach (old("items_pedido") as $produto_item)
                        <div class="select-row">
                            <select class="select-select" name="produtos[{{ $loop->index }}][id]">
                                @foreach ($produtos as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endforeach
                            </select>
                            <input class="select-input" type="number" name="produtos[{{ $loop->index }}][quantidade]" value="{{ $produto_item->quantidade }}" min="1" step="1" required>
                            @if ($loop->index == 0)
                                <button class="select-remove" style="visibility: hidden;" onclick="removeProdutoSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                            @else
                                <button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                            @endif
                        </div>
                    @endforeach
                @endif

            </div>
            <button class="select-add" type="button" onclick="appendProdutoSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>

        <div class="select-wrapper">
            <label>Coleções:</label>
            <div class="select-rows">

                @if (old("items_pedido"))
                    @foreach (old("items_pedido") as $colecao_item)
                        <div class="select-row">
                            <select class="select-select" name="colecoes[{{ $loop->index }}][id]">
                                @foreach ($colecoes as $colecao)
                                    <option value="{{ $colecao->id }}">{{ $colecao->nome }}</option>
                                @endforeach
                            </select>
                            <input class="select-input" type="number" name="colecoes[{{ $loop->index }}][quantidade]" value="{{ $colecao_item->quantidade }}" min="1" step="1" required>
                            @if ($loop->index == 0)
                                <button class="select-remove" style="visibility: hidden;" onclick="removeColecaoSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                            @else
                                <button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
                            @endif
                        </div>
                    @endforeach
                @endif

            </div>
            <button class="select-add" type="button" onclick="appendColecaoSelect(this)"><i class="fa-solid fa-plus"></i></button>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo endereço</button>
        </div>
    </form>
</div>

</span>