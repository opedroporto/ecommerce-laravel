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
    <div id="inner-container">
        <div id="rows">
            @foreach ($items as $item)
                <div class="row {{ $loop->index == 0 ? 'row-first' : '' }}" data-item-id="{{ $item['id'] }}">
                    @if ($item['tipo'] != "colecao")
                    <a class="clickable-item" href="{{ route("site.verproduto", [$item['produto']['id'], $item['produto']['slug']]) }}">
                    @else
                    <a class="clickable-item" href="{{ route("site.vercolecao", [$item['produto']['id'], $item['produto']['slug']]) }}">
                    @endif
                        <img class="row-img" src="{{ $item['produto']['img'] }}" alt="{{ $item['nome'] }}">
                    </a>
                    <div class="row-info">
                        <p>{{ $item['nome'] }}</p>
                        <p class="preço-info secondary-info">Preço: {{ number_format($item['valor'], 2, ",", ".") }}</p>
                        <p class="quantidade-info">Quantidade: {{ $item['quantidade'] }}</p>
                        @if ($item['tipo'] != "colecao")
                        <p class="quantidade-input-p"> Quantidade: <input class="quantidade-input" type="number" min="0" value="{{ $item['quantidade'] }}"></p>
                        @endif
                    </div>
                    <div class="row-options">
                        @if ($item['tipo'] != "colecao")
                        <span class="option-btn edit-item-btn"><i class="fa-solid fa-pencil fa-lg"></i></span>
                        <span class="option-btn save-item-btn"><i class="fa-solid fa-check fa-lg"></i></span>
                        <span class="option-btn close-item-btn"><i class="fa-solid fa-close fa-lg"></i></span>
                        @endif
                        <span class="option-btn delete-item-btn"><i class="fa-solid fa-trash fa-lg"></i></span>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="bottom-div">
            <p id="total-p">Total: {{ number_format($total, 2, ",", ".") }}</p>
            {{-- <form id="finalizar-form" action="{{ route("site.addpedido") }}" method="POST">
                @csrf
                <button id="finalizar-btn" type="submit">Fazer pedido</button>
            </form> --}}
            <div id="finalizar-form">
                <a id="finalizar-btn" href="{{ route("site.finalizarcompra") }}" type="submit">Fazer pedido</a>
            </div>
        </div>
    </div>
</div>



@else

<div id="title-wrapper">    
    <a id="goback-btn" href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i></a>
</div>

<div id="buy-btn-wrapper">
    <h2 id="buy-text">Seu carrinho está vazio.</h2>
    <a id="buy-btn" href="{{ url()->previous() }}">Conhecer produtos</a>
</div>

@endif

@endsection

@push("scripts")

<script>

    $(".edit-item-btn").on("click", function() {
        itemRow = $(this).closest(".row");

        $(itemRow).find(".edit-item-btn").hide();
        $(itemRow).find(".delete-item-btn").hide();

        $(itemRow).find(".save-item-btn").show();
        $(itemRow).find(".close-item-btn").show();

        $(itemRow).find(".quantidade-info").hide();
        $(itemRow).find(".quantidade-input-p").show();
    });

    $(".close-item-btn").on("click", function() {
        itemRow = $(this).closest(".row");

        $(itemRow).find(".edit-item-btn").show();
        $(itemRow).find(".delete-item-btn").show();

        $(itemRow).find(".save-item-btn").hide();
        $(itemRow).find(".close-item-btn").hide();

        $(itemRow).find(".quantidade-info").show();
        $(itemRow).find(".quantidade-input-p").hide();
    });

    $(".save-item-btn").on("click", async function() {
        itemRow = $(this).closest(".row");

        let id = $(itemRow).attr("data-item-id");
        let new_quantidade = $(itemRow).find(".quantidade-input").val();

        let response = await fetch("{{ route("site.edititem") }}", {
            "method": "POST",
            headers: {
                "X-CSRF-Token": "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                "id": id,
                "quantidade": new_quantidade
            })
        });

        let json_response = await response.json();
        console.log(json_response);

        if (json_response['quantidade'] == 0) {
            location.reload();
        }

        $(itemRow).find(".preço-info").text("Preço: " + json_response['valor']);
        $(itemRow).find(".quantidade-info").text("Quantidade: " + json_response['quantidade']);
        $(itemRow).find(".quantidade-input").val(json_response['quantidade']);

        $("#total-p").text("Total: " + json_response['total']);

        $(itemRow).find(".edit-item-btn").show();
        $(itemRow).find(".delete-item-btn").show();

        $(itemRow).find(".save-item-btn").hide();
        $(itemRow).find(".close-item-btn").hide();

        $(itemRow).find(".quantidade-info").show();
        $(itemRow).find(".quantidade-input-p").hide();
    });

    $(".delete-item-btn").on("click", async function() {
        itemRow = $(this).closest(".row");

        let id = $(itemRow).attr("data-item-id");

        let response = await fetch("{{ route("site.deleteitem") }}", {
            "method": "POST",
            headers: {
                "X-CSRF-Token": "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                "id": id
            })
        });

        location.reload();
    });

</script>

@endpush
