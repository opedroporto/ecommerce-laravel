	@extends("admin.layout")

@section("title", "Painel de controle")

@push('styles')
    
@endpush

<link rel="stylesheet" href="{{ asset("css/admin/produto/viewproduto.css") }}">


{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round"> --}}
{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}

@section("content")

<div class="container">
    <div class="item-wrapper">
        <div>
            <img src="{{ $produto->img }}" alt="Imagem de {{ $produto->nome }}">
        </div>
        <div class="item-details">
            <p>Nome: {{ $produto->nome }}</p>
            <p>Slug (não editável): {{ $produto->slug }}</p>
            <p>Descrição: {{ $produto->descricao }}</p>
            <p>Preço: {{ $produto->valor }}</p>
            <p>Quantidade: {{ $produto->quantidade }}</p>
            <p>Categoria: {{ $produto->categoria->nome }}</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
    </script>
@endpush
