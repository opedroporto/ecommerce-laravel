@extends("site.layout")

@section("title", "Sobre")

@push('styles')
    <link rel="stylesheet" href="{{ asset("css/site/sobre.css") }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap-grid.min.css" integrity="sha512-ZuRTqfQ3jNAKvJskDAU/hxbX1w25g41bANOVd1Co6GahIe2XjM6uVZ9dh0Nt3KFCOA061amfF2VeL60aJXdwwQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section("content")

<div class="img-wrapper">
	<img src="{{ asset("imgs/sobre/img9.webp") }}" class="img-banner" alt="">
	<div class="img-banner-text">Sobre nós</div>
</div>

<div class="container">
	<div class="row about-row">
		<div class="col about-col">
			<div class="img-wrapper">
				<img src="{{ asset("imgs/sobre/img3.webp") }}" class="img" alt="">
				<div class="img-text">Propósito</div>
			</div>
		</div>
		<div class="col about-col">
			<div class="about-text">
				<p class="about-p about-p-left">Nutrir a partilha de momentos especiais com pessoas especiais</p>
			</div>
		</div>
	</div>
	<div class="row about-row">
		<div class="col about-col">
			<div class="about-text">
				<p class="about-p about-p-right">Decorar festas e eventos, transformando momentos ordinários em extraordinários</p>
			</div>
		</div>
		<div class="col about-col">
			<div class="img-wrapper">
				<img src="{{ asset("imgs/sobre/img8.webp") }}" class="img" alt="">
				<div class="img-text">Missão</div>
			</div>
		</div>
	</div>
	<div class="row about-row">
		<div class="col about-col">
			<div class="img-wrapper">
				<img src="{{ asset("imgs/sobre/img2.webp") }}" class="img" alt="">
				<div class="img-text">Visão</div>
			</div>
		</div>
		<div class="col about-col">
			<div class="about-text">
				<p class="about-p about-p-left">Garantir que todos possam viver momentos mágicos ao lado de pessoas especiais</p>
			</div>
		</div>
	</div>
	

	<div class="row about-row about-row-sm">
		<p class="about-section-title">Nossos valores:</p>
		<div class="col-6 col-md-3 about-col">
			<div class="img-wrapper">
				<img src="{{ asset("imgs/sobre/img10.webp") }}" class="img-sm" alt="">
				<div class="img-text-sm">Cliente</div>
			</div>
		</div>
		<div class="col-6 col-md-3 about-col">
			<div class="img-wrapper">
				<img src="{{ asset("imgs/sobre/img7.webp") }}" class="img-sm" alt="">
				<div class="img-text-sm">União</div>
			</div>
		</div>
		<div class="col-6 col-md-3 about-col">
			<div class="img-wrapper">
				<img src="{{ asset("imgs/sobre/img1.webp") }}" class="img-sm" alt="">
				<div class="img-text-sm">Paixão</div>
			</div>
		</div>
		<div class="col-6 col-md-3 about-col">
			<div class="img-wrapper">
				<img src="{{ asset("imgs/sobre/img4.webp") }}" class="img-sm" alt="">
				<div class="img-text-sm">Diversidade</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<p class="about-section-title">Informações de contato:</p>
	<div class="contact-div">
		<p><a href="https://www.instagram.com/frandecoracoesepersonalizados" target="__blank"><i class="fa-brands fa-instagram"></i> @frandecoracoesepersonalizados</a></p>
		<a href="{{ getWhatsappLink(App\Models\Usuario::whereId(1)->first()->tel) }}" target="__blank"><p><i class="fa-brands fa-whatsapp"></i>&nbsp;{{ App\Models\Usuario::whereId(1)->first()->tel }}</p></a>
		<a href="mailto:{{ App\Models\Usuario::whereId(1)->first()->email }}" target="__blank"><p><i class="fa-solid fa-envelope"></i>&nbsp;{{ App\Models\Usuario::whereId(1)->first()->email }}</p></a>
		{{-- <a href="https://maps.google.com/?q={{ format_endereco(App\Models\Endereco::whereId(1)->first()) }}" target="__blank"><p><i class="fa-solid fa-location-dot"></i>&nbsp;{{ format_endereco(App\Models\Endereco::whereId(1)->first()) }}</p></a> --}}
	</div>
</div>

@endsection

@push('scripts')
    
@endpush