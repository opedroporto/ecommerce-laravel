@extends("site.layout")

@section("title")
@php    
    echo $colecao->nome;
@endphp

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset("css/site/verproduto.css") }}">
@endpush

@section("content")
    <div class="container">
        <div class="left-group">
            <div id="produto-img-wrapper">
                <img id="produto-img" src="{{ $colecao->img }}" />
            </div>
        </div>
        <div class="right-group">
            {{ $colecao->nome }} <br>
            {{ $colecao->descricao }} <br>

            <br>Contém:<br>
            @foreach ($colecao->produtos as $produto)
                {{ $produto['quantidade_colecao'] }} x {{ $produto[0]['nome'] }}<br>
            @endforeach

            <br>R$ {{ number_format($colecao->valor, 2, ",", ".") }}

            @if(isset($discount_value))
                <div>
                    <p>Comprando agora, você economiza R$ {{ number_format($discount_value, 2, ",", ".") }}!</p>
                </div>
            @endif

            <br>

            <form action="{{ route("site.carrinho") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="colecao">
            <input type="hidden" name="id" value="{{ $colecao->id }}">
            <button id="comprar-btn" type="submit">Comprar</button>
            </form>
        </div>
    </div>

@endsection
