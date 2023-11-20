@extends("admin.layout")

@section("title", "Painel de controle")

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> --}}
<link rel="stylesheet" href="{{ asset("css/admin/style.css") }}">
@push('styles')
<link rel="stylesheet" href="{{ asset("css/admin/index.css") }}">
@endpush
    
@section("content")

<div id="title-wrapper">
    <h1 id="title"> Painel de Controle: </h1>
</div>


<div class="container">
    <section class="section">
        <div class="section-title">
            <h2>Principais informações</h2>
        </div>
        <div class="section-items">
            {{-- <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-money-bill-trend-up fa-3x"></i>
                        <p>Faturamento total:</p>
                        <p>R$ {{ number_format($faturamento_total, 2, ",", ".") }}</p>
                    </div>
                </div>
            </article> --}}
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-cart-shopping fa-3x"></i>
                        <p>Faturamento do mês atual:</p>
                        <p>R$ {{ number_format($faturamento_mes, 2, ",", ".") }}</p>
                    </div>
                </div>
            </article>
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-regular fa-circle-check fa-3x"></i>
                        <p>Pedidos pagos este mês:</p>
                        <p>{{ $quantidade_pedidos_pagos_mes }}</p>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>

<div class="container">
    <section class="section">
        <div class="section-title">
            <h2><i class="fa-solid fa-cart-shopping"></i> Pedidos em aberto</h2>
        </div>
        <div class="section-items">
            {{-- <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-regular fa-circle-check fa-3x"></i>
                        <p>Pedidos pagos:</p>
                        <p>{{ $quantidade_pedidos_pagos_mes }}</p>
                    </div>
                </div>
            </article> --}}
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-spinner fa-3x"></i>
                        <p>Pedidos pendentes:</p>
                        <p>{{ $quantidade_pedidos_pendentes_mes }}</p>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>

<div class="container">
    <section class="section">
        <div class="section-title">
            <h2><i class="fa-solid fa-box"></i> Produtos</h2>
        </div>
        <div class="section-items">
            <article class="section-item">
                <div class="section-content">
                    <canvas id="produtosChart" class="chart"></canvas> 
                </div>
            </article>
        </div>
    </section>
</div>



<div class="container">
    <section class="section">
        <div class="section-title">
            <h2><i class="fa-solid fa-user"></i> Usuários</h2>
        </div>
        <div class="section-items">
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-user-tie fa-2x"></i>
                        <p>Administradores:</p>
                        <p>{{ $quantidade_admins }}</p>
                    </div>
                </div>
            </article>
            <article class="section-item">
                <div class="section-content">
                    <div class="section-inner-content">
                        <i class="fa-solid fa-users fa-2x"></i>
                        <p>Usuários:</p>
                        <p>{{ $quantidade_usuarios }}</p>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="section-items">
            <article class="section-item">
                <div class="section-content">
                    <canvas id="usuariosChart" class="chart"></canvas>
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

<script>

var bodyStyles = window.getComputedStyle(document.body);

var ctx = document.getElementById('usuariosChart');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [{{ $usuariosAno }}],
        datasets: [{
            label: "Cadastro de usuários",
            data: [{{ $usuariosTotal }}],
            backgroundColor: [
                bodyStyles.getPropertyValue('--light-secondary-color')
            ],
            borderColor: [                  
                bodyStyles.getPropertyValue('--secondary-color')
            ],
        borderWidth: 3, 
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var ctx = document.getElementById('produtosChart');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [{!! $categoriasLabel !!}],
        datasets: [{
            label: 'Produtos',
            data: [{{ $categoriasTotal }}],
            {{-- backgroundColor: [
                'rgba(255, 99, 132)',
                'rgba(54, 162, 235)',                         
                'rgba(255, 159, 64)'
            ] --}}
            backgroundColor: [
                @for ($i = 0; $i < $categoriasQnt; $i++)
                    "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }})",
                @endfor
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
    }
});

</script>

@endpush
