@extends("admin.layout")

@section("title", "Painel de controle")

@push('styles')
	<link rel="stylesheet" href="{{ asset("css/admin/crud/crud.css") }}">
	<link rel="stylesheet" href="{{ asset("css/admin/crud/popup.css") }}">
@endpush

@section("content")

<div class="container">
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="row-left">
					<h2><i class="fa-solid fa-box"></i> Painel de <b>Produtos</b></h2>
					<div class="search-div">
						<input class="search-input" type="text" placeholder="Pesquise por produtos" value="{{ request()->get('search') }}">
						<button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
				</div>
				<div class="row-right">
					@include("admin.produtos.modals.addmodal")
					@include("admin.produtos.modals.deletemanymodal")
				</div>
			</div>
		</div>
		<div class="table-scroll">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th></th>
						<th>ID</th>
						<th>Imagem</th>
						<th>Nome</th>
						<th>Preço</th>
						<th>Quantidade</th>
						<th>Categoria</th>
						<th>Opções</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($produtos as $produto)	
						<tr>
							<td>
								<span>
									<input type="checkbox" id="checkbox{{ $produto->id }}" class="row-checkbox" name="options[]" value="{{ $produto->id }}">
									<label for="checkbox{{ $produto->id }}"></label>
								</span>
							</td>
							<td>{{ $produto->id }}</td>
							<td><img class="td-img" src="{{ $produto->img }}" alt="Imagem de {{ $produto->nome }}"></td>
							<td>{{ Str::limit($produto->nome, 30) }}</td>
							<td>R$ {{ number_format($produto->valor, 2, ",", ".") }}</td>
							<td>{{ $produto->quantidade }}</td>
							<td>{{ Str::limit($produto->categoria->nome, 20) }}</td>
							<td class="options-td">
								@include("admin.produtos.modals.viewmodal", ["id" => $produto->id, "item" => $produto])
								@include("admin.produtos.modals.editmodal", ["id" => $produto->id, "item" => $produto])
								@include("admin.produtos.modals.deletemodal", ["id" => $produto->id])
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="clearfix">
			{{ $produtos->links("custom.paginator") }}
		</div>
	</div>
@endsection

@push('scripts')
    <script>
		$(".search-btn").click(() => {
			$(location).attr('href', "?search=" + $(".search-input").val());
		});

		var input = document.getElementById("myInput");

		$(".search-input").keyup(function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				$(".search-btn").click();
			}
		});
	</script>
@endpush