<!DOCTYPE html>
<html>

	<head>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
		<title>API</title>
		<style type="text/css"> .modal-dialog, .modal-content{ z-index:1051; } </style>
	</head>

	<body>

		<div class="container">

			<div class="row">
				<div class="col-md-12" style="margin-top: 20px;">
					<h4 class="text-center"> Read [R] </h4>
					<button type="button" class="btn btn-success" data-toggle="modal" href="#create">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						Add
					</button>
		 			<button type="button" class="btn btn-default pull-right" onclick="print()">
		 				<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
		 				Print
		 			</button>
		 			<hr><br>
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Ordem</th>
								<th class="text-center col-md-8">Nome</th>
								<th class="text-center">Data Nascimento</th>
								<th class="text-center"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<ul id="pagination" class="pagination-sm"></ul>
				</div>
			</div>

			<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="create">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title" id="create">Create [C]</h4>
						</div>
						<div class="modal-body">
							<form data-toggle="validator" method="POST">
								<div class="form-group">
									<label class="control-label" for="ordem"> Ordem </label>
									<input type="text" id="ordem" name="ordem" class="form-control" data-error="Este campo é obrigatório." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="data_nascimento"> Data Nascimento </label>
									<input type="text" id="data_nascimento" name="description" class="form-control" data-error="Este campo é obrigatório." required></textarea>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn crud-submit btn-success">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="update">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<h4 class="modal-title" id="update">Update [U]</h4>
						</div>
						<div class="modal-body">
							<form data-toggle="validator" action="api/update.php" method="put">
								<input type="hidden" name="id" class="edit-id">
								<div class="form-group">
									<label class="control-label" for="ordem"> Ordem </label>
									<input type="text" name="ordem" class="form-control" data-error="Este campo é obrigatório." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="data_nascimento"> Data Nascimento </label>
									<input type="text" name="description" id="data_nascimento" class="form-control" data-error="Este campo é obrigatório." required></textarea>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-success crud-submit-edit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<script src="./js/api.js"></script>
	</body>
</html>
