@extends("site.layout")

@section("title")
@php    
    echo $produto->nome;
@endphp

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset("css/site/verproduto.css") }}">
@endpush

@section("content")
    <div class="container">
        <div class="left-group">
            <div id="produto-img-wrapper">
                <img id="produto-img" src="{{ $produto->img }}" />
            </div>
        </div>
        <div class="right-group">
            {{ $produto->nome }} <br>
            R$ {{ number_format($produto->valor, 2, ",", ".") }} <br>
            {{ $produto->descricao }} <br>

            <form action="{{ route("site.carrinho") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $produto->id }}">
            <input type="number" name="quantidade" value="1">
            <button id="comprar-btn" type="submit">Comprar</button>
            </form>
        </div>
    </div>

@endsection
