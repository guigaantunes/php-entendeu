<?php
	$nomeModulo = "Clientes";
	$pathModulo	= getUrlTo(__FILE__);

  $modulo = "usuarios";
	
?>

<div class="page-usuarios page">
    <?//var_dump($permissoes)?>
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
	            <th data-priority="4">ID</th>
	            <th data-priority="3">Nome</th>
	            <th data-priority="5">Email</th>
	            <th data-priority="6">Data de Cadastro</th>
	            <th data-priority="7">Assinatura Ativa</th>
	            <th data-priority="8">Ativação Manual</th>
	            <th data-priority="9">Acesso VIP Manual</th>
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
	            { data: "nome", render: function(data) {
    	            return data ? data : '-'    ;
	            }},
	            { data: "email", },
	            { data: "data_cadastro_f", },
	            { data: "assinaturaAtiva", className: 'assinatura'},
	            { data: "ativacao_manual", render: function(data) {
    	            return data ? '<span style="color:green">Sim</span>' : 'Não';
	            }},
	            { data: "acesso_vip_manual", render: function(data) {
    	            return data ? '<span style="color:green">Sim</span>' : 'Não';
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
		    	//let acao = $trigger.find('td.criador').text();
		    	let possuiAssinatura = $trigger.find('td.assinatura').text();
                
                if (possuiAssinatura == 'Sim') {
                    menu = {
                        "editar":       {name: "Editar"},
        		        "assinatura":   {name: "Cancelar Assinatura"},
                        "excluir":      {name: "Excluir"},
                    };
                } else {
                    menu = {
                        "editar":       {name: "Editar"},
                        "excluir":      {name: "Excluir"},
                    };
                }
            
				items = menu;
        
                return {
                    items
                };   
		    },
	        callback: function(key, options) {
	            var id = $(this).attr("id");
		        if (!id)
		        	return true;
		        switch (key) {
			        case 'editar' :
			        	ajaxPopup('<?=$pathModulo?>form.php?id=' + id);
			        	break;
                    case 'historico':
                        
                        window.location.href = "/admin/historico-pagamento?id=" + id;
                        
                        break;
                    case 'assinatura':
                        
                        //jaxPopup('<?=$pathModulo?>form.php?id=' + id);
                        
                        confirmAction("Cancelar Assinatura", "Você deseja realmente cancelar a assiantura do cliente selecionado?").then(function(){
				        	$.ajax({
								type: 'POST',
								url: '<?=$pathModulo?>ajax.php',
								dataType: 'JSON',
								data: {acao: 'cancelar-assinatura', id: id},
								useDatatable: true
							})
							.done(ajaxDefaultReturn);
			        	});
                        
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
			        	});
			        	break;
			        case 'nada' :
			        	toast('Sem permissão');
			        	break;
			        default:
			        	toast('Erro', 'error');
			        	toast('Contacte um administrador', 'error');
		        }
	        },/*

	        items: {
		        "editar":       {name: "Editar"},
		        //"historico":    {name: "Histórico de Pagamentos"},
		        "assinatura":   {name: "Cancelar Assinatura"},
                "excluir":      {name: "Excluir"},
	        },
*/
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