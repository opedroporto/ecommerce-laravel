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
					<h2>Painel de <b>Categorias</b></h2>
					<div class="search-div">
						<input class="search-input" type="text" placeholder="Pesquise por categorias" value="{{ request()->get('search') }}">
						<button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
				</div>
				<div class="row-right">
					@include("admin.categorias.modals.addmodal")
					@include("admin.categorias.modals.deletemanymodal")
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Nome</th>
					<th>Descrição</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($categorias as $categoria)	
					<tr>
						<td>
							<span>
								<input type="checkbox" id="checkbox{{ $categoria->id }}" class="row-checkbox" name="options[]" value="{{ $categoria->id }}">
								<label for="checkbox{{ $categoria->id }}"></label>
							</span>
						</td>
						<td>{{ $categoria->id }}</td>
						<td>{{ Str::limit($categoria->nome, 40) }}</td>
						<td>{{ Str::limit($categoria->descricao, 20) }}</td>
						<td class="options-td">
							@include("admin.categorias.modals.viewmodal", ["id" => $categoria->id, "item" => $categoria])
							@include("admin.categorias.modals.editmodal", ["id" => $categoria->id, "item" => $categoria])
							@include("admin.categorias.modals.deletemodal", ["id" => $categoria->id])
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clearfix">
			{{ $categorias->links("custom.paginator") }}
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