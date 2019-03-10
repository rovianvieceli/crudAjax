$(document).ready(function() {

	var url = window.location.href;

	var getUrl = url + 'api/read.php';
	var createUrl = url + 'api/create.php';
	var deleteUrl = url + 'api/delete.php';

	var page = 1;
	var current_page = 1;
	var total_page = 0;
	var is_ajax_fire = 0;
	var screen = $('body');

	function manageData() {
		var data = {}
		data.page = page;

		$.ajax({
			dataType: 'json',
			url: getUrl,
			data: data
		}).done(function(xhr){
			$('#pagination').twbsPagination({
				totalPages: Math.ceil(xhr.total/10),
				visiblePages: page,
				onPageClick: function (event, pageL) {
					page = pageL;
					if(is_ajax_fire != 0){
						getPageData();
					}
				}
			});
			manageRow(xhr.data);
			is_ajax_fire = 1;
		});
	}

	function getPageData() {
		var data = {}
		data.page = page;

		$.ajax({
			dataType: 'json',
			url: getUrl,
			data: data,
		}).done(function(data){
			manageRow(data.data);
		});
	}

	function manageRow(data) {
		var rows = '';
		$.each( data, function( key, value ) {
			rows = rows + '<tr>';
			rows = rows + '<td class="text-center">'+value.id+'</td>';
			rows = rows + '<td class="text-center">'+value.ordem+'</td>';
			rows = rows + '<td>'+value.nome+'</td>';
			rows = rows + '<td class="text-center">'+value.dtnasc+'</td>';
			rows = rows + '<td data-id="'+value.id+'">';
			rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button> ';
			rows = rows + '<button class="btn btn-danger remove-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
			rows = rows + '</td>';
			rows = rows + '</tr>';
		});

		$("tbody").html(rows);
	}

	screen.on('click', '.crud-submit', function(e){
		e.preventDefault();

		var Form = $(this).closest('form');
		var ordem = Form.find("input[name='ordem']").val();
		var dtnasc = Form.find("input[name='data_nascimento']").val();

		if(ordem != '' && dtnasc != ''){
			var data = {};
			data.ordem = ordem;
			data.data_nascimento = dtnasc;

			$.ajax({
				dataType: 'json',
				type:'POST',
				url: createUrl,
				data:data
			}).done(function(data){
				Form.find("input[name='ordem']").val('')
				Form.find("input[name='data_nascimento']").val('');

				getPageData();

				$(".modal").modal('hide');

				toastr.success(
					'Registro adicionado com Sucesso.',
					'Success Alert', {
						timeOut: 5000
					}
				);
			});
		}else{
			toastr.error(
				'Não foi possível atulizar o Registro.',
				'Success Alert', {
					timeOut: 5000
				}
			);
		}
	});

	screen.on("click",".remove-item",function(){
		var data = {};
		data.id = $(this).parent("td").data('id');

		$.ajax({
			dataType: 'json',
			type:'POST',
			url: deleteUrl,
			data: data
		}).done(function(data){
			toastr.success(
				'Registro removido com Sucesso.',
				'Success Alert', {
					timeOut: 5000
				}
			);

			getPageData();
		});
	});

	$("body").on("click",".edit-item",function(){
		var id = $(this).parent("td").data('id');
		var title = $(this).parent("td").prev("td").prev("td").text();
		var description = $(this).parent("td").prev("td").text();

		$("#edit-item").find("input[name='title']").val(title);
		$("#edit-item").find("textarea[name='description']").val(description);
		$("#edit-item").find(".edit-id").val(id);
	});

	$(".crud-submit-edit").click(function(e){
		e.preventDefault();

		var form_action = $("#edit-item").find("form").attr("action");
		var title = $("#edit-item").find("input[name='title']").val();
		var description = $("#edit-item").find("textarea[name='description']").val();
		var id = $("#edit-item").find(".edit-id").val();

		if(title != '' && description != ''){
			$.ajax({
				dataType: 'json',
				type:'POST',
				url: url + form_action,
				data:{title:title, description:description,id:id}
			}).done(function(data){
				getPageData();
				$(".modal").modal('hide');
				toastr.success(
					'Registro atualizado com Sucesso.',
					'Success Alert', {
						timeOut: 5000
					}
				);
			});
		}else{
			toastr.error(
				'Não foi possível atulizar o Registro.',
				'Success Alert', {
					timeOut: 5000
				}
			);
		}
	});

	manageData();
});
