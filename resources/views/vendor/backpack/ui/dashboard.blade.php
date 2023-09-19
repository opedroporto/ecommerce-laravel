@extends(backpack_view('blank'))

{{-- @php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
@endphp --}}

@section('content')
    <link rel="stylesheet" href="{{ asset("css/fontawesome/css/all.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("css/reset.css") }}" />
    <link rel="stylesheet" href="{{ asset("css/variables.css") }}" /> 
    {{-- <link rel="stylesheet" href="{{ asset("css/admin/style.css") }}" /> --}}
    <link rel="stylesheet" href="{{ asset("css/admin/dashboard.css") }}">
    
    <div id="title-wrapper">
        <h1 id="title"> Painel de Controle </h1>
    </div>

    <div class="container">
        <section class="section">
            <div class="section-title">
                <h2>Principais informações</h2>
            </div>
            <div class="section-items">
                <article class="section-item">
                    <div class="section-content">
                        <div class="section-inner-content">
                            <i class="fa-solid fa-money-bill fa-4x"></i>
                            {{-- <p>Faturamento do mês atual: R$ {{ number_format($faturamento_mes, 2, ",", ".") }}</p> --}}
                            <p>Faturamento do mês atual: R$ 999</p>
                        </div>
                    </div>
                </article>
                <article class="section-item">
                    <div class="section-content">
                        <div class="section-inner-content">
                            <i class="fa-solid fa-cart-shopping fa-4x"></i>
                            {{-- <p>Pedidos este mês: {{ $quantidade_pedidos_mes }}</p> --}}
                            <p>Pedidos este mês: 99</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>

    <div class="container">
        <section class="section">
            <div class="section-title">
                <h2>Produtos</h2>
            </div>
            <div class="section-items">
                <article class="section-item">
                    <a href="{{ route("site.index") }}"><div class="section-content">
                        <canvas id="myChart2" height="100px"></canvas> 
                    </div></a>
                </article>
            </div>
        </section>
    </div>



    <div class="container">
        <section class="section">
            <div class="section-title">
                <h2>Usuários</h2>
            </div>
            <div class="section-items">
                <article class="section-item">
                    <div class="section-content">
                        <div class="section-inner-content">
                            <i class="fa-solid fa-circle-user fa-4x"></i>
                            {{-- <p>Administradores: {{ $quantidade_admins }}</p> --}}
                            <p>Administradores: 1</p>
                        </div>
                    </div>
                </article>
                <article class="section-item">
                    <div class="section-content">
                        <div class="section-inner-content">
                            <i class="fa-solid fa-circle-user fa-4x"></i>
                            {{-- <p>Total de usuários: {{ $quantidade_usuarios }}</p> --}}
                            <p>Total de usuários: 99</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="section">
            <div class="section-items">
                <article class="section-item">
                    <div class="section-content">
                        <canvas id="myChart" height="100px"></canvas>
                    </div>
                </article>
            </div>
        </section>    
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{ asset("js/admin/script.js") }}"></script>

@endsection