@extends("site.layout")

@section("title", "Pedidos")

@push('styles')
    <link rel="stylesheet" href="{{ asset("css/site/pedidos.css") }}">
@endpush

@section("content")

<div class="pedidos">
    @foreach ($pedidos as $pedido)
        <div class="pedido">
            <form action="{{ route("site.checkout") }}" method="GET">
                @csrf
                {{ $pedido }}
                <input name="id" type="hidden" value="{{ $pedido->id }}"> 
                <button type="submit">Comprar</button>
            </form>
        
            {{-- {{ $pedido }} --}}
            {{-- <a href="{{ $pedido->uri_pagamento }}">Comprar</a> --}}
        </div>
    @endforeach
</div>

@endsection

@push('scripts')
    
@endpush