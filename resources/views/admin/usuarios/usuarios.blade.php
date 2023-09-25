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
					<h2>Painel de <b>Usuários</b></h2>
					<div class="search-div">
						<input class="search-input" type="text" placeholder="Pesquise por usuários" value="{{ request()->get('search') }}">
						<button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
				</div>
				<div class="row-right">
					@include("admin.usuarios.modals.addmodal")
					@include("admin.usuarios.modals.deletemanymodal")
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Cargo</th>
					<th>Nome</th>
					{{-- <th>Sobrenome</th> --}}
					<th>E-mail</th>
					{{-- <th>CPF</th> --}}
					<th>Telefone</th>
					{{-- <th>Data de nascimento</th> --}}
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($usuarios as $usuario)	
					<tr>
						<td>
							<span>
								<input type="checkbox" id="checkbox{{ $usuario->id }}" class="row-checkbox" name="options[]" value="{{ $usuario->id }}">
								<label for="checkbox{{ $usuario->id }}"></label>
							</span>
						</td>
						<td>{{ $usuario->id }}</td>
						<td>{{ usuarioRole($usuario->role) }}</td>
						<td>{{ Str::limit($usuario->nome, 40) }}</td>
						{{-- <td>{{ Str::limit($usuario->sobrenome, 40) }}</td> --}}
						<td>{{ Str::limit($usuario->email, 40) }}</td>
						{{-- <td>{{ $usuario->cpf }}</td> --}}
						<td>{{ $usuario->tel }}</td>
						{{-- <td>{{ $usuario->dtnasc }}</td> --}}
						<td class="options-td">
							@include("admin.usuarios.modals.viewmodal", ["id" => $usuario->id, "item" => $usuario])
							@include("admin.usuarios.modals.editmodal", ["id" => $usuario->id, "item" => $usuario])
							@include("admin.usuarios.modals.deletemodal", ["id" => $usuario->id])
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clearfix">
			{{ $usuarios->links("custom.paginator") }}
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