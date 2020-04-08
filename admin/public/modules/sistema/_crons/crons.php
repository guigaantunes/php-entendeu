<div class="page page-usuarios">
<!--     <script src="<?=URL_SITE?>cliente/assets/js/pages/upgrade.js"></script> -->
	<div class="row">
    	
    	<div class="col s12">
			<h3 class="title-list admin-text text-escuro">Crons</h3>
			<div class="row">
                <div class="col s12">
					<ul id="lista-produtos">
        				<li class="item-lista">
    					    <div class="card">
        					    <div class="card-content">
            					    <div class="row" style="height: 50px">
									    <span class="card-title">Cron 1 - Remoção de clientes</span>
                                    
            					    </div>
            					    <hr>
									<div class="row">
									    <span class="card-price admin-text text-detalhe">Esta rotina efetua a remoção de clientes que possuem assinatura vencida a mais de n dias.</span>                
									</div>
                                    <a class="btn cron1" data-url="/admin/public/cron/cron_remocao_clientes.php">Executar</a>
        					    </div>
    					    </div>
    					</li>
    					<li class="item-lista">
    					    <div class="card">
        					    <div class="card-content">
            					    <div class="row" style="height: 50px">
									    <span class="card-title">Cron 2 - Conversão de pontos</span>
                                    
            					    </div>
            					    <hr>
									<div class="row">
									    <span class="card-price admin-text text-detalhe">Esta rotina efetua a conversão de pontos para valor real, seguindo as regras do plano, e verificando a situação do cliente.</span>                
									</div>
									<a class="btn cron2" data-url="/admin/public/cron/cron_conversao_pontos.php">Executar</a>
        					    </div>
    					    </div>
    					</li>
					</ul>				
				</div>
			</div>
			
    	</div>
    	
	</div>
	
	<script>
    	
    	$('.btn').on('click', function() {
        	var url = $(this).data('url');
        	
        	
        	confirmAction("Executar", "Você deseja executar a rotina de cron? A base de dados poderá ser modificada").then(function(){
            	window.open(url, '_blank');
            });
        	
    	});
    	
	</script>
	
</div>