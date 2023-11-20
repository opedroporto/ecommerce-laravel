@extends("site.layout")

@section("title", "Pedidos")

@push('styles')
    <link rel="stylesheet" href="{{ asset("css/site/pedidos.css") }}">
@endpush

@section("content")

@if (count($pedidos) > 0)

<div id="title-wrapper">
    
    <a id="goback-btn" href="{{ route("site.index") }}"><i class="fa-solid fa-arrow-left"></i> Produtos</a>

    <h1 id="title">Pedidos:</h1>
</div>

<div class="container">
    <div class="pedidos">
        @foreach ($pedidos as $pedido)
            @if(json_decode($pedido->session_data) != null)
                
                {{-- {{ json_decode($pedido->session_data)->status }} --}}
                @php
                    //$status_class = "pedido-" . explode(' ', trim(strtolower(translateStatus(json_decode($pedido->session_data)->status))))[0]
                    $status_class = "pedido-" . explode(' ', trim(strtolower(translateStatus($pedido->status))))[0]
                @endphp
                <div class="pedido {{ $status_class }}">

                    {{-- <p class="status-text">{{ translateStatus(json_decode($pedido->session_data)->status) }}<p> --}}
                    <p class="status-text">{{ translateStatus($pedido->status) }}<p>

                    Realizado em: {{ formatDatetime($pedido->created_at); }}<br>
                    @if ($pedido->entrega)
                        @php $pedido_modo = "entrega" ; @endphp
                        Modo: Entrega<br>
                    @elseif ($pedido->retirada)
                        @php $pedido_modo = "retirada" ; @endphp
                        Modo: Retirada<br>
                    @endif
                    Data de {{ $pedido_modo }}: {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pedido->data)->format('d/m/Y') }}<br>
                    Endereço de {{ $pedido_modo }}: {{ format_endereco($pedido->endereco) }}<br>
                    @if (json_decode($pedido->observacao))
                        Observação: {{ $pedido->observacao }}<br>
                    @endif

                    {{-- De " + date_split[2]+"/"+date_split[1]+"/"+date_split[0] + " às " + time_val + " até " +  date_split2[2]+"/"+date_split2[1]+"/"+date_split2[0] + " às " + time_val2 --}}

                    Data do evento: De {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pedido->data)->format('d/m/Y à\s H:i') }} até {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pedido->data_fim)->format('d/m/Y à\s H:i') }}<br>
                    Forma de pagamento: {{ $pedido->forma_de_pagamento->nome }}<br>

                    <div class="items-div">

                        @php
                            $hasProduto = false;
                            foreach($pedido->items_pedido as $item_pedido) {
                                if ($item_pedido->tipo == "produto") {
                                    $hasProduto = true;
                                }
                            }
                        @endphp
                        @if($hasProduto)
                            <label>Produtos:</label>
                            @foreach ($pedido->items_pedido as $item_pedido)
                                @if ($item_pedido->tipo == "produto")
                                    <div class="stage-details-item">
                                        <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                                        <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                        @php
                            $hasColecao = false;
                            foreach($pedido->items_pedido as $item_pedido) {
                                if ($item_pedido->tipo == "colecao") {
                                    $hasColecao = true;
                                }
                            }
                        @endphp
                        @if($hasColecao)
                            <label>Coleções:</label>
                            @foreach ($pedido->items_pedido as $item_pedido)
                                @if ($item_pedido->tipo == "colecao")
                                    <div class="stage-details-item">
                                        <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                                        <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    @if ($pedido->taxa_montagem)
                        <p id="stage-details-add">Adicional de montagem: <span class="light-text">R$ {{ number_format($pedido->taxa_montagem, 2, ",", ".") }}</span></p>
                    @endif

                    @if ($pedido->taxa_entrega)
                        <p id="stage-details-tax">Taxa de entrega: number_format($pedido->taxa_entrega, 2, ",", ".") }}<span id="stage-details-tax-text" class="light-text"></span></p>
                    @endif

                    <p class="total">Total: R$ {{ number_format($pedido->valor, 2, ",", ".") }}</p>

                    <br>

                    {{-- @if ($pedido->uri_pagamento && json_decode($pedido->session_data)->status == "open") --}}
                    @if ($pedido->uri_pagamento && $pedido->status == "open")
                        <div class="pay-btn-wrapper">
                            <a class="pay-btn" href="{{ $pedido->uri_pagamento }}"><i class="fa-solid fa-wallet"></i> Pagar</a>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach 
    </div>
</div>

@else

<div id="title-wrapper">    
    <a id="goback-btn" href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i></a>
</div>

<div id="buy-btn-wrapper">
    <h2 id="buy-text">Você ainda não fez nenhum pedido.</h2>
    {{-- <a id="buy-btn" href="{{ url()->previous() }}">Conhecer produtos</a> --}}
    <a id="buy-btn" href="{{ url()->route("site.index") }}">Conhecer produtos</a>
</div>

@endif

@endsection

@push('scripts')
    
@endpush