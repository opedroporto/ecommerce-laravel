<span>

<input type="checkbox" id="viewmodal{{ $id }}" class="modal-checkbox">
<label for="viewmodal{{ $id }}" class="view"><i class="fa-solid fa-eye"></i></label>

<label for="viewmodal{{ $id }}" class="modal-background"></label>
<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="viewmodal{{ $id }}"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.pedidos.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Visualizar pedido</h1>
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
            <input class="nospinbox {{ ($errors->first('valor') ? "input-error" : "") }}" type="number" name="valor" value="{{ $item->valor }}" min="0" step="0.01" required disabled>
            <p class="error-msg">{{ $errors->first('valor') ? $errors->first('valor') : "" }}</p>
        </div>

        <div>
            <label>Data do pedido:</label>
            <input class="{{ ($errors->first('data') ? "input-error" : "") }}" type="date" name="data" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->data)->format('Y-m-d') }}" required disabled>
            <p class="error-msg">{{ $errors->first('data') ? $errors->first('data') : "" }}</p>
        </div>

        <div>
            <label>Modo (Entrega / Retirada):</label>
            <fieldset class="modo-fieldset" required disabled>
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
            <input class="nospinbox {{ ($errors->first('taxa_entrega') ? "input-error" : "") }}" type="number" name="taxa_entrega" value="{{ $item->taxa_entrega }}" min="0" step="0.01" required disabled>
            <p class="error-msg">{{ $errors->first('taxa_entrega') ? $errors->first('taxa_entrega') : "" }}</p>
        </div>

        <div>
            <label>Observação:</label>
            <textarea id="observacao" class="{{ ($errors->first('observacao') ? "input-error" : "") }}" type="text" name="observacao" placeholder="" rows="2" cols="20" required disabled>{{ $item->observacao }}</textarea>
            <p class="error-msg">{{ $errors->first('observacao') ? $errors->first('observacao') : "" }}</p>
        </div>

        <div>
            <label>URI de pagamento:</label>
            <input class="{{ ($errors->first('uri_pagamento') ? "input-error" : "") }}" type="text" name="uri_pagamento" value="{{ $item->uri_pagamento }}" required disabled>
            <p class="error-msg">{{ $errors->first('uri_pagamento') ? $errors->first('uri_pagamento') : "" }}</p>
        </div>

        <div>
            <label>Pago:</label>
            <input type="checkbox" name="pago" {{ $item->pago ? "checked" : "" }} required disabled>
            <p class="error-msg">{{ $errors->first('pago') ? $errors->first('pago') : "" }}</p>
        </div>

        <div>
            <label>Forma de pagamento:</label>
            <select class="{{ ($errors->first('id_forma_de_pagamento') ? "input-error" : "") }}" name="id_forma_de_pagamento" required disabled>
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
            <select class="{{ ($errors->first('id_endereco') ? "input-error" : "") }}" name="id_endereco" required disabled>
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
            <select class="{{ ($errors->first('id_usuario') ? "input-error" : "") }}" name="id_usuario" required disabled>
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

        <div>
            <label>Produtos:</label>
            @foreach ($item->items_pedido as $item_pedido)
                @if ($item_pedido->tipo == "produto")
                    <div class="stage-details-item">
                        <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                        <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
                    </div>
                @endif
            @endforeach
            <label>Coleções:</label>
            @foreach ($item->items_pedido as $item_pedido)
                @if ($item_pedido->tipo == "colecao")
                    <div class="stage-details-item">
                        <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                        <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo produto</button>
        </div> --}}
    </form>
</div>

</span>