$(function(){	
	
	var excluir = function(){
		const li = $(this).closest("li");
		const id = li.attr("id");
        swal({
			title: "Excluir Arquivo",   
			text: "Tem certeza que deseja excluir esse arquivo?",   
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#FDC689",
			confirmButtonText: "Sim",
			cancelButtonText: 'Não',
			closeOnConfirm: false
		},
		(isConfirm) => {
			if(isConfirm){
				$.ajax({
					type: 'POST',
					url: '/admin/public/modules/sistema/arquivo/ajax.php', 
					dataType: 'JSON',
					data: {acao: 'excluir', id: id}
				})
				.done(function(res) {
					showMessages(res.mensagens);
					swal.close();
					
					if(res.status) {
						$(li).fadeOut(200);
						setTimeout($(li).remove, 201);
					}
				});
			}
		});
	}
	
	var myDropzone = new Dropzone(".dropzone");
	myDropzone.on("success", function(file, res) {
		res = $.parseJSON(res);
		showMessages(res.mensagens);
		
		if(res.status) {
			$(".images-list").html('');
			$.each(res.dados.arquivos, function(){
				var file = this;
				var newLi = 
					`<li class="collection-item avatar" id="${file.id}">
						<img src="${urlImagens}p${file.id}${file.arquivo}" alt="" class="circle large">
						<div class="row">
							<div class="acoes col s1 right right-align">
								<a class="excluirFoto" class="btn-flat waves-effect waves-darken tooltipped" data-position="bottom" data-delay="50" data-tooltip="Excluir"><i class="material-icons">&#xE872;</i></a>
							</div>
						</div>
					</li>`;
				$(".images-list").append(newLi);
				$('.tooltipped').tooltip({delay: 50});
			})
			myDropzone.removeFile(file);
		}
		
	});
	
	$('.images-list').on("click", 'a.excluirFoto', excluir);
	
});