@extends("site.layout")

@section("title", "Home")

@push('styles')
    
@endpush
    <link rel="stylesheet" href="{{ asset("css/site/index.css") }}">
@section("content")

@foreach ($pedidos as $pedido)
    {{ $pedido }}
@endforeach

@endsection

@push('scripts')
    
@endpush