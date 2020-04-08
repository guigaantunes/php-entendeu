<?php
	$nomeModulo = "URLs";
	$pathModulo	= URL_ADMIN."public/modules/seo/urls/";
?>

<div class="breadcrumb-content">
	<a class="breadcrumb" href="/admin">SEO</a>
	<a class="breadcrumb" href="javascript:void(0)"><?=$nomeModulo?></a>
</div>
<div class="page-usuarios page" data-page="14"  data-subpage="2">
    <div class="header-table">
		<h1><?=$nomeModulo?></h1>
		<div class="acoes">
			<a href="<?=$pathModulo?>form.php" class="ajax-popup-link btn-flat waves-effect waves-darken add cor-admin-text text-cor-detalhe"><i class="material-icons left">&#xE146;</i>Novo</a>
		</div>
	</div>
	<table class="data-table display nowrap striped highlight" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	            <th data-priority="1"></th>
	            <th data-priority="3">ID</th>
	            <th data-priority="4">Página Origem</th>
	            <th data-priority="5">Página Destino</th>
	            <th data-priority="6">Data de Cadastro</th>
	            <th data-priority="2"></th>
	        </tr>
	    </thead>
	</table>
</div>
<script>
	$(document).ready(function() {		
	    $('.data-table').DataTable( {
	        responsive: true,
	        select: true,
	        language: { 
		        select: { rows: { _: "%d linhas selecionadas", 0: "", 1: "1 linha selecionada"}},
		        buttons: { colvis: ''}
		    },
	        colReorder: true,
	        ajax: "<?=$pathModulo?>ajax.php?get",
	        dom: 'Bfrtip',
	        stateSave: true,
	        buttons: [
		        {
			        text: '',
			        className: 'waves-effect waves-darken cor-admin-text text-cor-cinza-texto reload-button',
				    action: function ( e, dt, node, config ) {
				        Materialize.toast('Atualizando...', 2000);
				        dt.ajax.reload();
				    }
		        },
	            {
	                extend: 'colvis',
	                collectionLayout: 'fixed two-column',
	                className: 'waves-effect waves-darken cor-admin-text text-cor-cinza-texto'
	            },
	        ],
	        columns: [
	            {
	                data: null,
	                defaultContent: '',
	                className: 'control',
	                orderable: false
	            },
	            { data: "id", },
	            { data: "origem", },
	            { data: "destino", },
	            { data: "data_cadastro", },
	            {
		            width: '50px',
	                data: null,
	                defaultContent: '',
	                className: 'action',
	                orderable: false
	            },
	        ],
	    });
	});
	$(function(){
		var table = $('.data-table').DataTable();
		var magnificPopup = $.magnificPopup.instance; 
	    var Row = $(this);
	    table.rows().deselect();
	    var selecionado = table.row(Row, { page: 'current' }).select();
	    
	    $('.data-table').contextMenu({
	        selector: 'tbody tr', 
	        callback: function(key, options) {
	            if (key === "editar") {
					magnificPopup.open({
						items: {
							src: '<?=$pathModulo?>form.php?id=' + $(this).attr("id")
						},
						type: 'ajax',
						showCloseBtn: true,
						removalDelay: 500,
						mainClass: 'mfp-zoom-in',
						tLoading: '',
						
						
						callbacks: {
						    ajaxContentAdded: function() {
							    heightMain();
								pluginsMaterialize();
								//Inicializar o editor de texto
								initTinymce();
						    },
						    close: function() {
						    	heightMainReset();
						    }
						}
					}, 0);
	            } else if (key === "excluir") {
		            var rowId = $(this).attr("id");
		            swal({
						title: "Excluir URL?",   
						text: "Tem certeza que deseja excluir essa url?",   
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#FDC689",
						confirmButtonText: "Sim",
						cancelButtonText: 'Não',
						closeOnConfirm: false
					},
					function(isConfirm){
						if(isConfirm){
								$.ajax({
								type: 'POST',
								url: '<?=$pathModulo?>ajax.php',
								dataType: 'JSON',
								data: {acao: 'excluir', id: rowId}
							})
							.done(function(res) {
								if(res.tipo == 'sucesso'){
									$('.data-table').DataTable().ajax.reload();
									swal("Excluir URL", res.mensagem, 'success');
								}else{
									swal("Excluir URL", res.mensagem, 'error');
								}
								
							});
						}
						
					});
	            }
	        },
	        items: {
	            "editar":   {name: "Editar", isHtmlName: true},
	            "excluir":    {name: "Excluir", isHtmlName: true}
	        },
	        events: {
				show : function(options){
				    var table = $('.data-table').DataTable();
				    table.rows().deselect();
				    table.row(this, { page: 'current' }).select();        
				}            
			}
	    });
	});
	$('.data-table').on('click', '.action', function(e){
	   currentRow = $(this).parent();
       $(currentRow).contextMenu({x: e.pageX, y: e.pageY});
	});
</script>