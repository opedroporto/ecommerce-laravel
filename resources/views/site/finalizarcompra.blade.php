@extends("site.layout")

@section("title", "Carrinho")

@push('styles')
    
@endpush
    <link rel="stylesheet" href="{{ asset("css/site/finalizarcompra.css") }}">
@section("content")

<div class="container">
    
    <h1 id="title">Finalize seu pedido:</h1>

    <section class="section-stage">
        Forma:<br>
        <fieldset id="group0" style="display:flex;flex-direction:column;">
            <input type="radio" value="value1" name="group0">Entrega
            <input type="radio" value="value2" name="group0">Retirada
        <button>Usar a forma acima</button>
    </section>

    <section class="section-stage">
        Endereço do local:<br>
        <fieldset id="group1" style="display:flex;flex-direction:column;">
            @foreach ($enderecos as $endereco)
                <input type="radio" value="value1" name="group1">{{ $endereco }}
            @endforeach
            <button>Adicionar outro  endereço</button>
        </fieldset>
        <button>Escolher o endereço acima</button>
    </section>

    <section class="section-stage">
        Data do evento:<br>
        
        <input type="date">
        
        <button>Escolher a data acima</button>
    </section>
    
    <section class="section-stage">
        Método de pagamento:<br>
        <fieldset id="group2" style="display:flex;flex-direction:column;">
            <input type="radio" value="value4" name="group2">Pix
            <input type="radio" value="value2" name="group2">Cartão de crédito
            <input type="radio" value="value3" name="group2">Cartão de débito
            <input type="radio" value="value1" name="group2">Boleto
        </fieldset>
        <button>Usar a forma de pagamento acima</button>
    </section>

    <section class="section-stage">
        Revisar pedido:<br>
    </section>
    
    <button>Finalizar Pedido</button>
</div>


@endsection
