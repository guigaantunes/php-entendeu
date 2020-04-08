<?php
	$nomeModulo = "Material de Estudo";
	$pathModulo	= getUrlTo(__FILE__);
	
	$modulo = "materialestudo";

?>

<div class="page-usuarios page">
    <div class="header-table">
		<h1><?=$nomeModulo?></h1>
		<div class="acoes">
			<a href="<?=$pathModulo?>form.php" class="ajax-popup-link mfp-large btn-flat waves-effect waves-darken add cor-admin-text text-cor-detalhe"><i class="material-icons left">&#xE146;</i>Novo</a>
		</div>
	</div>
	<table class="data-table display nowrap striped highlight" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	            <th data-priority="1"></th>
	            <th data-priority="3">ID</th>
	            <th data-priority="4">Título</th>
	            <th data-priority="6">Matéria</th>
	            <th data-priority="7">É Demonstrativo?</th>
	            <th data-priority="4">Ordem</th>
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
		    rowReorder: {
			    	dataSrc: 'ordem',
			    	selector: '.ordem'
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
	            { data: "id", className: 'reorder' },
	            { data: "titulo", },
	            { data: "caminho_topico", },
                { data: "demonstrativo", render: function(data){
                    return data ? '<span style="color:green">Sim</span>' : 'Não';
                }},
                { data: "ordem", name: 'ordem', className: 'ordem' },
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
		
		table.on( 'row-reorder', function ( e, diff, edit ) {
			var arrOrder = [];
							
			$(e.target.rows).each(function( i, e) {
				arrOrder[e.rowIndex] = e.id;					
			});
			 
			$.ajax({
				type: 'POST',
				url: '<?=$pathModulo?>ajax.php',
				dataType: 'JSON',
				data: {acao: 'ordem', order: arrOrder},
				useDatatable: true
			})
			.done(
				$('.data-table').DataTable().ajax.reload()
			);
				
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
		        	case 'imagem' :
	        	    var tipo = $(this).find('.tipo').text();
			        	ajaxPopup('/admin/public/modules/sistema/arquivo/form.php?tabela=materialestudo&tipo=principal&id=' + id);
			        	break;
              case 'arquivo' :
	        	    var tipo = $(this).find('.tipo').text();
			        	ajaxPopup('/admin/public/modules/sistema/arquivo/form.php?tabela=materialestudo&tipo=arquivo&id=' + id);
			        	break;
			        case 'seo-meta':
			        	ajaxPopup('/admin/public/modules/seo/metas/form.php?pagina=topico&identificador=' + id);
			        	break;
			        case 'seo-url':
			        	ajaxPopup('/admin/public/modules/seo/urls/form.php?id='+id+'&urlOrigem=topico/' + id);
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
		        "editar":   {name: "Editar"},
		        "imagem":   {name: "Imagem"},
		        "arquivo":  {name: "Arquivo"},
		        "seo-meta": {name: "Seo Meta"},
		        "seo-url":  {name: "Seo Url"},
		        "excluir":  {name: "Excluir"},
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