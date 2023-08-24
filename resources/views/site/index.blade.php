@extends("site.layout")

@section("title", "Home")

@push('styles')
    
@endpush
    <link rel="stylesheet" href="{{ asset("css/site/index.css") }}">
@section("content")

<div id="container">
    <div id="columns">
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
    </div>
    <div id="left-group">
        <div>
            <div>
                <h1>CRIE AQUI <br> SUAS PRÓPRIAS <br> DECORAÇÕES</h1>
            </div>
            <div id="buttons-left-group">
                <button id="comprar-btn">Comprar</button>
                <button id="criar-btn">Criar</button>
            </div>
        </div>
    </div>
    <div id="right-group">
        <img id="main-img" src="{{ asset("imgs/dec.jpg") }}"/>
    </div>
</div>
<div id="main">
    <section id="produtos">
        <h2>Produtos:</h2>
        <div id="produtos-grid">
            @foreach ($produtos as $produto)    
                <a href="{{ route("site.verproduto", [$produto->id, $produto->slug]) }}">
                    <div class="card">
                        <div class="card-img-wrapper">
                            <img class="card-img" src="{{ $produto->img }}" />
                        </div>
                        <p class="card-title">{{ $produto->nome }}</p> <br>
                        <p class="card-subtitle">R$ {{ number_format($produto->valor, 2, ",", ".") }}</p> <br>
                        <p>{{ Str::limit($produto->descricao, 255) }}</p>
                    </div>
                </a>
            @endforeach
            <!-- <div class="card">
                <div class="card-img-wrapper">
                    <img class="card-img" src="./carros.jpg"></img>
                    <p class="card-title">Festa de aniversário</p>
                </div>
            </div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div> -->
        </div>
    </section>
</div>

@endsection

@push('scripts')
    <script src="{{ asset("js/site/index.js") }}"></script>
@endpush
