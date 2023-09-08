@extends("admin.layout")

@section("title", "Painel de controle")

@push('styles')
    
@endpush
    <link rel="stylesheet" href="{{ asset("css/site/index.css") }}">
@section("content")

<h1> Painel de Controle </h1><br>

<a href="{{ route("admin.produtos.index") }}">Produtos</a>
{{-- <br> --}}
{{-- <a href="{{ route("admin.produtos.add") }}">+ Adicionar Produtos</a> --}}

@endsection

@push('scripts')
    
@endpush
