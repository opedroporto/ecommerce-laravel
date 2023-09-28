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
					<h2>Painel de <b>Pedidos</b></h2>
					<div class="search-div">
						<input class="search-input" type="text" placeholder="Pesquise por pedidos" value="{{ request()->get('search') }}">
						<button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
				</div>
				<div class="row-right">
					@include("admin.pedidos.modals.addmodal")
					@include("admin.pedidos.modals.deletemanymodal")
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Preço</th>
					<th>Status</th>
					<th>Modo</th>
					<th>Usuário</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($pedidos as $pedido)	
					<tr class="tr-pedido tr-{{ $pedido->pago ? "pago" : "pendente" }}">
						<td>
							<span>
								<input type="checkbox" id="checkbox{{ $pedido->id }}" class="row-checkbox" name="options[]" value="{{ $pedido->id }}">
								<label for="checkbox{{ $pedido->id }}"></label>
							</span>
						</td>
						<td>{{ $pedido->id }}</td>
						<td>R$ {{ number_format($pedido->valor) }}</td>
						<td>{{ json_decode($pedido->session_data)->status }}</td>
						<!-- <td>{{ $pedido->pago ? "Pago" : "Pagamento pendente" }}</td> -->
						<td>{{ $pedido->entrega ? "Entrega" : "Retirada" }}</td>
						{{-- <td>{{ format_endereco($endereco) }}</td> --}}
						@if ($pedido->usuario)
							<td><a href="{{ route("admin.usuarios.index", ["id=" . $pedido->usuario->id]) }}">{{ "(" . (string)$pedido->usuario->id . ") " . (string)$pedido->usuario->nome }}</a></td>
						@else
							<td></td>
						@endif
						<td class="options-td">
							@include("admin.pedidos.modals.viewmodal", ["id" => $pedido->id, "item" => $pedido])
							@include("admin.pedidos.modals.editmodal", ["id" => $pedido->id, "item" => $pedido])
							@include("admin.pedidos.modals.deletemodal", ["id" => $pedido->id])
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clearfix">
			{{ $pedidos->links("custom.paginator") }}
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

		function appendProdutoSelect(addBtn) {
			let rows_wrapper = $(addBtn.closest(".select-wrapper")).find(".select-rows");
			console.log(rows_wrapper);
			let current_row_index = $(rows_wrapper).find(".select-row").length;
			$(rows_wrapper).append(`
				<div class="select-row">
					<select name="produtos[${current_row_index}][id]">
						@foreach ($produtos as $produto)
							<option value="{{ $produto->id }}">{{ $produto->nome }}</option>
						@endforeach
					</select>
					<input class="select-input" type="number" name="produtos[${current_row_index}][quantidade]" value="1" min="1" step="1" required>
					<button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
				</div>
			`);
			rows = $(rows_wrapper).find(".select-row");
			rows.each(function(i, row) {
				if (rows.length == 2 && i > 0 && !$(row).has(".select-remove").length) {
					$(row).append(`<button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>`);
				}
			});
		}

		function appendColecaoSelect(addBtn) {
			let rows_wrapper = $(addBtn.closest(".select-wrapper")).find(".select-rows");
			console.log(rows_wrapper);
			let current_row_index = $(rows_wrapper).find(".select-row").length;
			$(rows_wrapper).append(`
				<div class="select-row">
					<select name="colecoes[${current_row_index}][id]">
						@foreach ($colecoes as $colecao)
							<option value="{{ $colecao->id }}">{{ $colecao->nome }}</option>
						@endforeach
					</select>
					<input class="select-input" type="number" name="colecoes[${current_row_index}][quantidade]" value="1" min="1" step="1" required>
					<button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>
				</div>
			`);
			rows = $(rows_wrapper).find(".select-row");
			rows.each(function(i, row) {
				if (rows.length == 2 && i > 0 && !$(row).has(".select-remove").length) {
					$(row).append(`<button class="select-remove" onclick="removeSelect(this)"><i class="fa-solid fa-xmark"></i></button>`);
				}
			});
		}
		function removeSelect(btn) {
			$(btn).closest(".select-row").remove();
		}
	</script>
@endpush