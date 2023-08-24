@extends("site.layout")

@section("title", "Carrinho")

@push('styles')
    
@endpush
    <link rel="stylesheet" href="{{ asset("css/site/carrinho.css") }}">
@section("content")

@if ($quantidadeItemsCarrinho > 0)

<div id="title-wrapper">
    
    <a id="goback-btn" href="{{ route("site.index") }}"><i class="fa-solid fa-arrow-left"></i> Produtos</a>

    <h1 id="title">Carrinho ({{ count($items) }} {{ count($items) == 1 ? 'item' : 'itens' }}):</h1>
</div>
    
<div class="container">
    @foreach ($items as $item)
        <a href="{{ route("site.verproduto", [$item['produto']['id'], $item['produto']['slug']]) }}">
            <div class="row {{ $loop->index == 0 ? 'row-first' : '' }}">
                <img class="row-img" src="{{ $item['produto']['img'] }}" alt="{{ $item['nome'] }}">
                <div class="row-info">
                    <p>{{ $item['nome'] }}</p>
                    <p>{{ number_format($item['valor'], 2, ",", ".") }}</p>
                    <p> Quantidade: {{ $item['quantidade'] }}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>

<div id="bottom-div">
    <p>Total: {{ number_format($total, 2, ",", ".") }}</p>
    {{-- <form id="finalizar-form" action="{{ route("site.addpedido") }}" method="POST">
        @csrf
        <button id="finalizar-btn" type="submit">Fazer pedido</button>
    </form> --}}
    <div id="finalizar-form">
        <a id="finalizar-btn" href="{{ route("site.finalizarcompra") }}" type="submit">Fazer pedido</a>
    </div>
</div>

@else

<div id="title-wrapper">
    
    <a id="goback-btn" href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i></a>

    <h1 id="title">Carrinho vazio :(</h1>
</div>

@endif

@endsection
