<?php
	$nomeModulo = "Configuração";
	$pathModulo	= getUrlTo(__FILE__);
	
	$modulo = "configuracao";

?>

<div class="page-usuarios page">
    <div class="header-table">
		<h1><?=$nomeModulo?></h1>
		<div class="acoes">
			<a></a>
		</div>
	</div>
	<table class="data-table display nowrap striped highlight" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	            <th data-priority="1"></th>
	            <th data-priority="7">ID</th>
	            <th data-priority="3">E-mail</th>
	            <th data-priority="4">YouTube</th>
	            <th data-priority="5">Facebook</th>
	            <th data-priority="6">Instagram</th>
	            <th data-priority="2"></th>
	        </tr>
	    </thead>
	</table>
</div>
<script>
	$(function() {
    	
    	
		var magnificPopup = $.magnificPopup.instance;
	    var table = $('.data-table').DataTable({
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
	            { data: "email_contato", },
	            { data: "youtube", render: function(data){
    	            return 'https://youtube.com/'+data;
	            }},
	            { data: "facebook", render: function(data){
    	            return 'https://facebook.com/'+data;
	            }},
                { data: "instagram", render: function(data){
    	            return 'https://instagram.com/'+data;
	            }},
	            {
		            width: '50px',
	                data: null,
	                defaultContent: '',
	                className: 'action',
	                orderable: false
	            },
	        ],
	    }).on('click', '.action', function(e){
		    currentRow = $(this).parent();
	        $(currentRow).contextMenu({x: e.pageX, y: e.pageY});
		});
	    
	    $('.data-table').contextMenu({
	        selector: 'tbody tr', 
	        callback: function(key, options) {
		        var id = $(this).attr("id");
		        if (!id)
		        	return true;
		        	
		        switch (key) {
			        case 'editar' :
			        	ajaxPopup('<?=$pathModulo?>form.php?id=' + id);
			        	break;
		        	case 'banner-desk' :
		        	    var tipo = $(this).find('.tipo').text();
			        	ajaxPopup('/admin/public/modules/sistema/arquivo/form.php?tabela=banner&tipo=banner&id=' + id);
			        	break;
                    case 'banner-mob' :
		        	    var tipo = $(this).find('.tipo').text();
			        	ajaxPopup('/admin/public/modules/sistema/arquivo/form.php?tabela=banner&tipo=banner_mob&id=' + id);
			        	break;
			        case 'excluir' :
			        	confirmAction("Exclusão de Registro", "Você deseja realmente excluir o registro selecionado?").then(function(){
				        	$.ajax({
								type: 'POST',
								url: '<?=$pathModulo?>ajax.php',
								dataType: 'JSON',
								data: {acao: 'excluir', id: id},
								useDatatable: true
							})
							.done(ajaxDefaultReturn);	
			        	})
			        	break;
			        default:
			        	toast('Erro', 'error');
			        	toast('Contacte um administrador', 'error');
		        }
	        },
	        items: {
		        "editar":       {name: "Editar"},
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
</script>