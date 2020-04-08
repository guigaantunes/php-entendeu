<?php
	$nomeModulo = "Histórico de Pagamentos";
	$pathModulo	= getUrlTo(__FILE__);

    $modulo = "historicopagamento";
    $id = $_GET['id'];
	
?>

<div class="page-usuarios page">
    <div class="header-table">
		<h1><?=$nomeModulo?></h1>
		<div class="acoes">
    		<a></a>
<!-- 			<a href="<?=$pathModulo?>form.php" class="ajax-popup-link mfp-large btn-flat waves-effect waves-darken add cor-admin-text text-cor-detalhe"><i class="material-icons left">&#xE146;</i>Novo</a> -->
		</div>
	</div>
	<table class="data-table display nowrap striped highlight" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	            <th data-priority="1"></th>
	            <th data-priority="4">ID</th>
	            <th data-priority="3">Cliente</th>
<!-- 	            <th data-priority="5">Assinatura</th> -->
	            <th data-priority="6">Plano</th>
	            <th data-priority="7">Valor</th>
	            <th data-priority="7">Data Vencimento</th>
	            <th data-priority="7">Data Pagamento</th>
	            <th data-priority="2"></th>
	        </tr>
	    </thead>
	</table>
</div>
<script>
	$(function() {		
	    var table = $('.data-table').DataTable( {
	        responsive: true,
	        select: true,
	        language: { 
		        select: { rows: { _: "%d linhas selecionadas", 0: "", 1: "1 linha selecionada"}},
		        buttons: { colvis: ''}
		    },
	        colReorder: true,
	        ajax: "<?=$pathModulo?>ajax.php?id=<?=$id?>",
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
	            { data: "DT_RowId", },
	            { data: "nome", },
	            { data: "plano", },
	            { data: "valor", },
	            { data: "data_vencimento", },
	            { data: "data_pagamento", className: "pagamento", render: function(data) {
    	            return data == '00/00/0000' ? '-' : data;
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
	        build: function($trigger, e) {
    	        let pago = $trigger.find('td.pagamento').text();
    	        
    	        if (pago == '-') {
        	        return {
                        items: {
                            "baixa": {name: "Dar Baixa"},
                        }
                    };
        	    } else {
            	    return false;
        	    }
    	        
                
            },
	        callback: function(key, options) {
	            var id = $(this).attr("id");
		        if (!id)
		        	return true;
		        switch (key) {
/*
			        case 'editar' :
			        	ajaxPopup('<?=$pathModulo?>form.php?id=' + id);
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
*/
                    case 'baixa':
                        confirmAction("Baixa em Fatura", "Você deseja realmente dar baixa na fatura selecionada?").then(function(){
                            $.ajax({
                                'method'        : 'POST',
                                'updateScreen'  : true,
                                'url'           : '/admin/public/modules/historicopagamento/ajax.php',
                                'data'          : {acao: 'baixa', dados: {id: id}}
                            })
                            .done(ajaxDefaultReturn);
                        });
                        
                        break;
			        case 'nada' :
			        	toast('Sem permissão');
			        	break;
			        default:
			        	toast('Erro', 'error');
			        	toast('Contacte um administrador', 'error');
		        }
	        },
	        items: {
/*
		        "editar":   {name: "Editar"},
                "excluir":   {name: "Excluir"},
*/
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