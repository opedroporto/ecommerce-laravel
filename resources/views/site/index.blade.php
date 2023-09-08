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
    @if (isset($colecoes))
    <section id="itens">
        <h2>Coleções:</h2>
        <div id="produtos-grid">
            @foreach ($colecoes as $colecao)
                <a href="{{ route("site.vercolecao", [$colecao->id, $colecao->slug]) }}">
                    <div class="card">
                        <div class="card-img-wrapper">
                            <img class="card-img" src="{{ $colecao->img }}" />
                        </div>
                        <p class="card-title">{{ $colecao->nome }}</p> <br>
                        {{-- <p class="card-subtitle">R$ {{ number_format($produto->valor, 2, ",", ".") }}</p> <br> --}}
                        <p>{{ Str::limit($colecao->descricao, 150) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @elseif(isset($produtos))
    <section id="itens">
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
                        <p>{{ Str::limit($produto->descricao, 150) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

@endsection

@push('scripts')
    <script src="{{ asset("js/site/index.js") }}"></script>

    <script>
        $("#comprar-btn").click(() => {
            $(location).attr('href', "{{ route("site.index", []) }}");
        });

        $("#criar-btn").click(() => {
            $(location).attr('href', "{{ route("site.index", ["modo" => "criar"]) }}");
        });
    </script>
@endpush
