	@extends("admin.layout")

@section("title", "Painel de controle")

@push('styles')
    
@endpush

<link rel="stylesheet" href="{{ asset("css/admin/produto/produtos.css") }}">


{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round"> --}}
{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}

@section("content")

<div class="container">
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="row-left">
					<h2>Painel de <b>Produtos</b></h2>
					<div id="search-div">
						<input id="search-input" type="text" placeholder="Pesquise por produtos" value="{{ request()->get('search') }}">
						<button id="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
				</div>
				<div class="row-right">
					{{-- <a href="#addModal" class="btn btn-add"><i class="fa-solid fa-plus"></i> <span>Novo produto</span></a> --}}
					@include("admin.produtos.includes.addpopup")
					{{-- <a href="#deleteModal" class="btn btn-delete"><i class="fa-solid fa-trash"></i> <span>Deletar</span></a> --}}
					@include("admin.produtos.includes.deletemanypopup")
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>
						{{-- <span class="custom-checkbox">
							<input type="checkbox" id="selectAll">
							<label for="selectAll"></label>
						</span> --}}
					</th>
					<th>ID</th>
					<th>Imagem</th>
					<th>Nome</th>
					{{-- <th>Descrição</th> --}}
					<th>Preço</th>
					<th>Quantidade</th>
					<th>Categoria</th>
					<th>Opções</th>
					{{-- <th>Visualizar</th>
					<th>Editar</th>
					<th>Deletar</th> --}}
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
						<td>{{ Str::limit($produto->nome, 40) }}</td>
						{{-- <td>{{ Str::limit($produto->descricao, 40) }}</td> --}}
						<td>{{ number_format($produto->valor, 2, ",", ".") }}</td>
						<td>{{ $produto->quantidade }}</td>
						<td>{{ Str::limit($produto->categoria->nome, 20) }}</td>
						{{-- <td>
							<a href="{{ route("admin.produtos.show", $produto->id) }}" class="view"><i class="fa-solid fa-eye"></i></a>
						</td>
						<td>
							<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="fa-solid fa-pencil"></i></a>
						</td>
						<td>
							<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="fa-solid fa-trash"></i></a>
						</td> --}}
						<td class="options-td">
							{{-- <a href="{{ route("admin.produtos.show", $produto->id) }}" class="view"><i class="fa-solid fa-eye"></i></a> --}}
							@include("admin.produtos.includes.viewpopup", ["id" => $produto->id, "produto" => $produto])
							{{-- <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="fa-solid fa-pencil"></i></a> --}}
							@include("admin.produtos.includes.editpopup", ["id" => $produto->id, "produto" => $produto])
							@include("admin.produtos.includes.deletepopup", ["id" => $produto->id])
							{{-- <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="fa-solid fa-trash"></i></a> --}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clearfix">
			{{ $produtos->links("custom.paginator") }}
		</div>
	</div>
{{-- </div>
<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Edit Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="text" class="form-control" required>
					</div>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div> --}}

@endsection

@push('scripts')
    <script>

		$("#search-btn").click(() => {
			$(location).attr('href', "?search=" + $("#search-input").val());
		});

		var input = document.getElementById("myInput");

		$("#search-input").keyup(function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				$("#search-btn").click();
			}
		});

        
		$(".file-upload-input").on("dragenter", function(event) {
			{{-- event.preventDefault();
			event.stopPropagation(); --}}
			let file_upload_el = $(this).closest(".file-upload");
			$(file_upload_el).find(".image-upload-wrap").addClass("file-dragover");
		});

		$(".file-upload-input").on("dragleave", function(event) {
			{{-- event.preventDefault();
			event.stopPropagation(); --}}
			let file_upload_el = $(this).closest(".file-upload");
			$(file_upload_el).find(".image-upload-wrap").removeClass("file-dragover");
		});


		function readURL(input) {
			let file_upload_el = $(input).closest(".file-upload");

			if (input.files && input.files[0]) {

				var reader = new FileReader();

				reader.onload = function(e) {
					$($(file_upload_el).find('.image-upload-wrap')).hide();

					$((file_upload_el).find('.file-upload-image')).attr('src', e.target.result);
					$((file_upload_el).find('.file-upload-content')).show();

					$((file_upload_el).find('.image-title')).html(input.files[0].name);
				};

				reader.readAsDataURL(input.files[0]);

			} else {
				console.log(input);
				removeUpload(input);
			}
		}

		function removeUpload(input) {
			console.log(input);
			let file_upload_el = $(input).closest(".file-upload");

			$($(file_upload_el).find('.file-upload-input')).replaceWith($($(file_upload_el).find('.file-upload-input')).clone());
			$($(file_upload_el).find('.file-upload-content')).hide();
			$($(file_upload_el).find('.image-upload-wrap')).show();
		}
    </script>
@endpush