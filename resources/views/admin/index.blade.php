@extends("admin.layout")

@section("title", "Painel de controle")

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> --}}
<link rel="stylesheet" href="{{ asset("css/admin/style.css") }}">
@push('styles')
<link rel="stylesheet" href="{{ asset("css/admin/index.css") }}">
@endpush
    
@section("content")

<div id="title-wrapper">
    <h1 id="title"> Painel de Controle </h1>
</div>

<div class="container ">
    <section class="section">
        <div class="section-title">
            <h2>Principais informações</h2>
        </div>
        <div class="section-items">
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-money-bill fa-4x"></i>
                        <p>Faturamento do mês atual: R$ {{ number_format($faturamento_mes, 2, ",", ".") }}</p>
                    </div>
                </div>
            </article>
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-cart-shopping fa-4x"></i>
                        <p>Pedidos este mês: {{ $quantidade_pedidos_mes }}</p>
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
                <a href="{{ route("admin.produtos.index") }}"><div class="section-content">
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
                        <p>Administradores: {{ $quantidade_admins }}</p>
                    </div>
                </div>
            </article>
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-circle-user fa-4x"></i>
                        <p>Total de usuários: {{ $quantidade_usuarios }}</p>
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

@endsection

@push('scripts')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> --}}
{{-- <script type="module" src="{{ asset("js/chart/chart.js") }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script src="{{ asset("js/admin/script.js") }}"></script>

@endpush
