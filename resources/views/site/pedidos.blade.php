@extends("site.layout")

@section("title", "Pedidos")

@push('styles')
    <link rel="stylesheet" href="{{ asset("css/site/pedidos.css") }}">
@endpush

@section("content")

<div class="pedidos">
    @foreach ($pedidos as $pedido)
        @php
            $status_class = "pedido-" . explode(' ', trim(strtolower(translateStatus(json_decode($pedido->session_data)->status))))[0]
        @endphp
        <div class="pedido {{ $status_class }}">
            {{-- <form action="{{ route("site.checkout") }}" method="GET">
                @csrf
                {{ $pedido }}
                <input name="id" type="hidden" value="{{ $pedido->id }}"> 
                <button type="submit">Pagar</button>
            </form> --}}

            <p class="status-text"> Status: {{ translateStatus(json_decode($pedido->session_data)->status) }}<p>
            @if ($pedido->entrega)
                @php $pedido_modo = "entrega" ; @endphp
                Modo: Entrega<br>
            @elseif ($pedido->retirada)
                @php $pedido_modo = "retirada" ; @endphp
                Modo: Retirada<br>
            @endif
            <div class="items-div">
                <label>Produtos:</label>
                @foreach ($pedido->items_pedido as $item_pedido)
                    @if ($item_pedido->tipo == "produto")
                        <div class="stage-details-item">
                            <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                            <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
                        </div>
                    @endif
                @endforeach
                <label>Coleções:</label>
                @foreach ($pedido->items_pedido as $item_pedido)
                    @if ($item_pedido->tipo == "colecao")
                        <div class="stage-details-item">
                            <img class="satage-details-item-img" src="{{ $item_pedido['produto']['img'] }}">
                            <p>{{ $item_pedido['nome'] }} <span class="light-text">Preço: R$ {{ number_format($item_pedido['valor'], 2, ",", ".") }} ({{ $item_pedido['quantidade'] }} x R$ {{ number_format($item_pedido['produto']['valor'], 2, ",", ".") }})</span></p>
                        </div>
                    @endif
                @endforeach
                
                @if ($pedido->taxa_montagem)
                    <p id="stage-details-add">Adicional de montagem: <span class="light-text">R$ {{ number_format($pedido->taxa_montagem, 2, ",", ".") }}</span></p>
                @endif

                @if ($pedido->taxa_entrega)
                    <p id="stage-details-tax">Taxa de entrega: number_format($pedido->taxa_entrega, 2, ",", ".") }}<span id="stage-details-tax-text" class="light-text"></span></p>
                @endif

                
                <p id="stage-details-total">Total: R$ {{ number_format($pedido->valor, 2, ",", ".") }}<br><span id="stage-details-total-text" class="light-text"></span></p>
            </div>

            <br>
            {{-- <div class="tab">
                Taxa de entrega: {{ number_format($pedido->taxa_entrega, 2, ",", ".") }}<br>
                Taxa de montagem: {{ number_format($pedido->taxa_montagem, 2, ",", ".") }}<br>
            </div> --}}
            Data de {{ $pedido_modo }}: {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pedido->data)->format('d/m/Y') }}<br>
            Endereço de {{ $pedido_modo }}: {{ format_endereco($pedido->endereco) }}<br>
            @if (json_decode($pedido->observacao))
                Observação: {{ $pedido->observacao }}<br>
            @endif
            Realizado em: {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pedido->created_at)->format('d/m/Y') }}<br>

            <br>

            @if (json_decode($pedido->session_data)->url)
                <a href="{{ json_decode($pedido->session_data)->url }}">Pagar</a>
            @endif
        </div>
    @endforeach
</div>

@endsection

@push('scripts')
    
@endpush