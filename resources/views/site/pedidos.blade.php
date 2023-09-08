@extends("site.layout")

@section("title", "Home")

@push('styles')
    
@endpush
    <link rel="stylesheet" href="{{ asset("css/site/index.css") }}">
@section("content")

@foreach ($pedidos as $pedido)
    {{-- <form action="{{ route("site.checkout") }}" method="POST">
        @csrf
        {{ $pedido }}
        <input name="id" type="hidden" value="{{ $pedido->id }}"> 
        <button type="submit">Comprar</button>
    </form> --}}

    {{ $pedido }}
    <a href="{{ route("site.checkout", ["id" => $pedido->id]) }}">Comprar</a>
@endforeach

@endsection

@push('scripts')
    
@endpush