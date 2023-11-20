@extends("site.layout")

@section("title")
@php    
    echo $colecao->nome;
@endphp

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset("css/site/verproduto.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap-grid.min.css" integrity="sha512-ZuRTqfQ3jNAKvJskDAU/hxbX1w25g41bANOVd1Co6GahIe2XjM6uVZ9dh0Nt3KFCOA061amfF2VeL60aJXdwwQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section("content")

    <div class="container first-container">
        <div class="left-group">
            <div id="produto-img-wrapper">
                <img id="produto-img" src="{{ $colecao->img }}" />
            </div>
        </div>
        <div class="right-group">
            <div class="right-group-text">
                <h1 class="item-title">{{ $colecao->nome }}</h1>
                <div class="secondary-text">
                    <p>Contém:<p>
                    <ul class="items-list">
                        @foreach ($colecao->produtos as $produto)
                            <li><p>&nbsp;&nbsp;&nbsp;&nbsp;{{ $produto['quantidade_colecao'] }} x {{ $produto[0]['nome'] }}</p></li>
                        @endforeach
                    </ul>
                </div>

                <div class="item-price-group">
                    <p class="item-price">
                        R$ {{ number_format($colecao->valor, 2, ",", ".") }}
                    </p>
                    @if(isset($invalid_price) && isset($discount_percentage))
                        <span id="discount-badge">
                            <span class="w3-badge">{{ $discount_percentage }}</span>
                        </span>
                    @endif
                </div>
                
                @if(isset($invalid_price) && isset($discount_percentage))
                    <div>
                        <p class="invalid-item-price">R$ {{ number_format($invalid_price, 2, ",", ".") }}</p>
                    </div>
                @endif
            </div>

            <form action="{{ route("site.carrinho") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $colecao->id }}">
                <input type="hidden" name="type" value="colecao">


                <div class="row form-row">
                    <div class="col-sm-12 col-md-6 col-group input-group">
                        <input type="button" value="-" class="btn-minus" data-field="quantidade"><input type="number" step="1" min="0" max="" value="1" class="numinput nospinbox" name="quantidade" onkeydown="return false;"><input type="button" value="+" class="btn-plus" data-field="quantidade">
                    </div>
                    <div class="col-sm-12 col-md-6 col-group">
                        <button id="comprar-btn" type="submit">
                            <i class="fa-solid fa-cart-shopping"></i>&nbsp;Adicionar ao carrinho
                        </button>
                    </div>
                </div>
            </form>

            @if ($errors->any())
                <div class="error-msg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>

    <div class="container second-container">
        <h2 class="item-description-title">Descrição da decoração:</h2>
        @if(!empty($colecao->descricao))
        <p class="item-description">{{ $colecao->descricao }}</p>
        @else
        <p class="item-description subtext">Nenhuma descrição.</p>
        @endif
    </div>

@endsection


@push("scripts")

<script>
    function incrementValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

    if (!isNaN(currentVal)) {
        parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
    } else {
        parent.find('input[name=' + fieldName + ']').val(0);
    }
    }

    function decrementValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

    if (!isNaN(currentVal) && currentVal > 0) {
        parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
    } else {
        parent.find('input[name=' + fieldName + ']').val(0);
    }
    }

    $('.input-group').on('click', '.btn-plus', function(e) {
        incrementValue(e);
    });

    $('.input-group').on('click', '.btn-minus', function(e) {
        decrementValue(e);
    });

</script>

@endpush