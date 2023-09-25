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
					<h2>Painel de <b>Endereços</b></h2>
					<div class="search-div">
						<input class="search-input" type="text" placeholder="Pesquise por endereços" value="{{ request()->get('search') }}">
						<button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
				</div>
				<div class="row-right">
					@include("admin.enderecos.modals.addmodal")
					@include("admin.enderecos.modals.deletemanymodal")
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Endereço</th>
					<th>Usuário</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($enderecos as $endereco)	
					<tr>
						<td>
							<span>
								<input type="checkbox" id="checkbox{{ $endereco->id }}" class="row-checkbox" name="options[]" value="{{ $endereco->id }}">
								<label for="checkbox{{ $endereco->id }}"></label>
							</span>
						</td>
						<td>{{ $endereco->id }}</td>
						<td>{{ format_endereco($endereco) }}</td>
						@if ($endereco->usuario)
							<td><a href="{{ route("admin.usuarios.index", ["id=" . $endereco->usuario->id]) }}">{{ "(" . (string)$endereco->usuario->id . ") " . (string)$endereco->usuario->nome }}</a></td>
						@else
							<td></td>
						@endif
						<td class="options-td">
							@include("admin.enderecos.modals.viewmodal", ["id" => $endereco->id, "item" => $endereco])
							@include("admin.enderecos.modals.editmodal", ["id" => $endereco->id, "item" => $endereco])
							@include("admin.enderecos.modals.deletemodal", ["id" => $endereco->id])
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clearfix">
			{{ $enderecos->links("custom.paginator") }}
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