@extends("site.layout")

@section("title", "Home")

@push('styles')
    
@endpush
    <link rel="stylesheet" href="{{ asset("css/site/index.css") }}">
@section("content")

<section class="Home">
        
    <div class="slideshow-container">
        <a href="{{ route('site.sobre') }}">
            <div class="mySlides fade">
                <img class="slide-img" src="{{ asset('imgs/banner1.png') }}">
            </div>
        </a>

        <a href="{{ route('site.index', []) }}#itens">
            <div class="mySlides fade">
                <img class="slide-img" src="{{ asset('imgs/banner2.png') }}">
            </div>
        </a>

        <a href="{{ route('site.index', []) }}#itens">
            <div class="mySlides fade">
                <img class="slide-img" src="{{ asset('imgs/banner3.png') }}">
            </div>
        </a>
    </div>

    <div id="dots">
        <span class="dot" data-img="0"></span> 
        <span class="dot" data-img="1"></span> 
        <span class="dot" data-img="2"></span> 
    </div>

    {{-- <img class="content-img" src="{{ asset("imgs/fran.jpg") }}" alt="">
    <h1>CRIE AQUI <br> SUAS PRÓPRIAS <br> DECORAÇÕES</h1> --}}
    
    <div id="main">
        @if (isset($colecoes))
        <section id="itens">
            <div class="switch-btn-group">
                <button id="comprar-btn" class="switch-btn switch-btn-active" disabled><i class="fa-solid fa-boxes-stacked"></i> Decorações</button>
                <button id="criar-btn" class="switch-btn"><i class="fa-solid fa-box"></i> Produtos</button>
            </div>
            <h1 class="title">Decorações:</h1>
            <div id="produtos-grid">
                @foreach ($colecoes as $colecao)
                    <a href="{{ route("site.vercolecao", [$colecao->id, $colecao->slug]) }}">
                        <div class="card">
                            <div class="card-img-wrapper">
                                <img class="card-img" src="{{ $colecao->img }}" />
                            </div>
                            <p class="card-title">{{ $colecao->nome }}</p> <br>
                            <p class="card-subtitle">R$ {{ number_format($colecao->valor, 2, ",", ".") }}</p> <br>
                            @if(!empty($colecao->descricao))
                            <p class="card-description">{{ Str::limit($colecao->descricao, 150) }}</p>
                            @else
                            <p class="card-description subtext">Nenhuma descrição.</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        @elseif(isset($produtos))
        <section id="itens">
            <div class="switch-btn-group">
                <button id="comprar-btn" class="switch-btn"><i class="fa-solid fa-boxes-stacked"></i> Decorações</button>
                <button id="criar-btn" class="switch-btn switch-btn-active" disabled><i class="fa-solid fa-box"></i> Produtos</button>
            </div>
            <h1 class="title">Produtos:</h1>
            <div id="select-wrapper">
                Categoria:
                <select id="select" name="categoria">
                    <option value="0">Todas</option>
                    @foreach ($categorias as $categoria)
                        @if(app('request')->input('categoria') == $categoria->id)
                        <option value="{{ $categoria->id }}" selected>{{ $categoria->nome }}</option>
                        @else
                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div id="produtos-grid">
                @foreach ($produtos as $produto)    
                    <a href="{{ route("site.verproduto", [$produto->id, $produto->slug]) }}">
                        <div class="card">
                            <div class="card-img-wrapper">
                                <img class="card-img" src="{{ $produto->img }}" />
                            </div>
                            <p class="card-title">{{ $produto->nome }}</p> <br>
                            <p class="card-subtitle">R$ {{ number_format($produto->valor, 2, ",", ".") }}</p> <br>
                            @if(!empty($produto->descricao))
                            <p class="card-description">{{ Str::limit($produto->descricao, 150) }}</p>
                            @else
                            <p class="card-description subtext">Nenhuma descrição.</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>

</section>

@endsection

@push('scripts')
    <script src="{{ asset("js/site/index.js") }}"></script>

    <script>

        let slideIndex = 0;
        let slideTimeout;
        showSlides();

        $(".dot").on("click", function() {
            slideIndex = $(this).data("img");
            clearTimeout(slideTimeout);
            showSlides();
        });

        function showSlides() {
            let clicked = false;
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}    
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " active";

            slideTimeout = setTimeout(showSlides, 5000);
        }
    </script>

    <script>
        $("#comprar-btn").click(() => {
            $(location).attr('href', "{{ route("site.index", []) }}" + "#itens");
        });

        $("#criar-btn").click(() => {
            $(location).attr('href', "{{ route("site.index", ["modo" => "criar"]) }}" + "#itens");
        });

        $("#select").on("change", function() {
            let id_categoria = $(this).val();
            $(location).attr('href', "{{ route("site.index", ["modo" => "criar"]) }}" + "&categoria=" + id_categoria + "#itens");
        });
    </script>
@endpush