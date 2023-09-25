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
					<h2>Painel de <b>Coleções</b></h2>
					<div class="search-div">
						<input class="search-input" type="text" placeholder="Pesquise por coleções" value="{{ request()->get('search') }}">
						<button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
				</div>
				<div class="row-right">
					@include("admin.colecoes.modals.addmodal", ["produtos" => $produtos])
					@include("admin.colecoes.modals.deletemanymodal")
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Imagem</th>
					<th>Nome</th>
					<th>Preço</th>
					<th>Quantidade</th>
					{{-- <th>Categoria</th> --}}
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($colecoes as $colecao)
					<tr>
						<td>
							<span>
								<input type="checkbox" id="checkbox{{ $colecao->id }}" class="row-checkbox" name="options[]" value="{{ $colecao->id }}">
								<label for="checkbox{{ $colecao->id }}"></label>
							</span>
						</td>
						<td>{{ $colecao->id }}</td>
						<td><img class="td-img" src="{{ $colecao->img }}" alt="Imagem de {{ $colecao->nome }}"></td>
						<td>{{ Str::limit($colecao->nome, 40) }}</td>
						<td>R$ {{ number_format($colecao->valor, 2, ",", ".") }}</td>
						<td>{{ $colecao->quantidade }}</td>
						{{-- <td>{{ Str::limit($produto->categoria->nome, 20) }}</td> --}}
						<td class="options-td">
							@include("admin.colecoes.modals.viewmodal", ["id" => $colecao->id, "item" => $colecao])
							@include("admin.colecoes.modals.editmodal", ["id" => $colecao->id, "item" => $colecao])
							@include("admin.colecoes.modals.deletemodal", ["id" => $colecao->id])
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clearfix">
			{{ $colecoes->links("custom.paginator") }}
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

		function appendSelect(addBtn) {
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
		function removeSelect(btn) {
			$(btn).closest(".select-row").remove();
		}
	</script>

@endpush