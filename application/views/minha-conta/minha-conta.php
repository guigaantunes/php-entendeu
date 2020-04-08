<?php
    
    if ( !isset($_SESSION['cliente']['id']) ) {
        echo "<script>window.location.href = '/login'</script>";
    }

    $dev = isset($_GET['dev']) ? true : false;
    
    $class          = new Cliente;
    $classPlano     = new Plano;
    $classFatura    = new Fatura;
    $classAssinatura= new Assinatura;
    
    $id             = $_SESSION['cliente']['id'];
    $cliente        = $class->getById($_SESSION['cliente']['id']);
    //$assinatura     = $classAssinatura->getAssinatura();
    
    
    // if($plano) {
    //     $dataInicio         = DateTime::createFromFormat('Y-m-d H:i:s', $cliente['data_cadastro'] );
        
    //     if ($dataInicio)
    //         $dataInicioFormatada= $dataInicio->format('d/m/Y');
        
    //     $dataFim            = clone $dataInicio;
    //     if($dataFim) {
    //         $dataFim            = $dataFim->add(new DateInterval("P{$plano[meses]}M"));
    //         $dataFimFormatada   = $dataFim->format('d/m/Y');
    //     }
    // }
    
    
    $minhasFaturas = $classFatura->getBy(
        $dados = array(
            'fatura.status' => 1,
            'fatura.id_cliente' => $_SESSION['cliente']['id']  
        ) ,
        $campos = array(
            'fatura.*',
            'plano.titulo as plano',
            'DATE_FORMAT(fatura.data_vencimento, "%d/%m/%Y") as data_formatada'
        ),
        $inner = array(
            'assinatura' => array(
                'assinatura.id' => 'fatura.id_assinatura'
            ),
            'plano' => array(
                'plano.id' => 'assinatura.id_plano'
            )
        )
    );

/*

    $ultimaFatura           = $classFatura->getFatura();
    $dataInicio             = DateTime::createFromFormat('Y-m-d H:i:s', $ultimaFatura['data_cadastro']);
    if($dataInicio)
        $dataInicioFormatada= $dataInicio->format('d/m/Y');

    $dataFim                = DateTime::createFromFormat('Y-m-d H:i:s', $ultimaFatura['data_termino_assinatura']);
    if($dataFim)
        $dataFimFormatada   = $dataFim->format('d/m/Y');
*/

    

    $assinatura = $classAssinatura->getAssinatura();
    $plano      = $classPlano->getById($assinatura['id_plano']);
    
    if ($assinatura && $assinatura['pagseguro_adesao'])
        $assinaturaAtiva = $classAssinatura->assinaturaAtiva();
    if($_GET['debug']){
      var_dump($cliente);
    }
if($_GET['planos']=="vip"){
  $escolha = "planos";
}
else{
  $escolha = "planos";
}
?> 


<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Minha Conta</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a class="select-hover">Minha Conta</a> 
			
		</div>
	</div>
</section>

<section class="section-space separate-all max-size spaces-top">
	<div class="minha-conta">
		<div class="form-box">
			<a class="title text-gray text-center">Minha conta <i class="icon-crown big-icon text-orange"></i> </a>
			<form  class="form" action="/admin/public/modules/cliente/ajax.php" method="POST" id='form-login' data-redirect="/<? echo $escolha;?>">
    			<input type="hidden" name="acao" value="editar">
    			<input type="hidden" name="id" value="<?=$id?>">
<!--     			<input type="hidden" name="dados[vip]" value="<?=$cliente['vip']?>"> -->
    			    			
	    		<div class="input-field required" data-error="Informe seu nome">
	    			<input id="nome" type="text" name="dados[nome]" placeholder="Nome" class="required" value="<?=$cliente['nome']?>" required />
	    		</div>
<!--
	    		<div class="input-field required" data-error="Informe seu nome">
	    			<input id="email" type="text" name="dados[email]" placeholder="E-mail" class="required" value="<?=$cliente['email']?>" required />
	    		</div>
-->
	    		<div class="input-field required" data-error="Informe seu Celular">
	    			<input id="telefone" type="text" name="dados[telefone]" placeholder="Telefone" class="required mask-telefone" value="<?=$cliente['telefone']?>" required />
	    		</div>
	    		<div class="input-field required" data-error="Informe seu cpf">
	    			<input id="cpf" type="text" name="dados[cpf]" placeholder="CPF" class="required mask-cpf" value="<?=$cliente['cpf']?>" required />
	    		</div>
	    		<div class="input-field required" data-error="Informe seu cep">
	    			<input id="cep" type="text" name="dados[cep]" placeholder="CEP" class="required mask-cep cep" value="<?=$cliente['cep']?>" required />
	    		</div>
	    		<div class="input-field required" data-error="Informe sua cidade">
	    			<input id="cidade" type="text" data-cep="city" name="dados[cidade]" placeholder="Cidade" class="required" value="<?=$cliente['cidade']?>" required />
	    		</div>
	    		<div class="input-field required" data-error="Informe sua uf">
	    			<input id="uf" type="text" data-cep="state_min" name="dados[uf]" placeholder="UF" class="required" value="<?=$cliente['uf']?>" required />
	    		</div>
	    		<div class="input-field required" data-error="Informe seu endereço">
	    			<input id="endereco" type="text" data-cep="street" name="dados[endereco]" placeholder="Endereço" class="required" value="<?=$cliente['endereco']?>" required />
	    		</div>
	    		<div class="input-field required" data-error="Informe seu endereço">
	    			<input id="numero" type="number" min="1" name="dados[numero]" placeholder="Número" class="required" value="<?=$cliente['numero']?>" required />
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="senha" type="password" name="dados[senha]" placeholder="***********" class="" />
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="csenha" type="password" name="dados[csenha]" placeholder="Confirmar Senha" class="" />
	    		</div>
	    		<div class="input-field required" >
		    		<a href="javascript:void(0)" class="btn btn-send" id='btn-send'>enviar</a>
	    		</div>
	    		<div class="enviar">
    				<button type="submit" class="btn orange btn-small orange-hover">Salvar Alterações</button>
    			</div>
			</form>

		</div>
	</div>
	<?if($assinatura):?>
		<div class="section-plans">
    	<div class="col-plans">
    		<div class="plans">
    			<div class="plan">
    				<div class="flag top-flag <?=($assinaturaAtiva ? 'green' : 'orange')?>">
        				<?if($assinaturaAtiva):?>
    					    <a class="flag-text">SEU PLANO ATIVO</a>
    					<?else:?>
    					    <a class="flag-text">PAGAMENTO PENDENTE</a>
    					<?endif;?>
    				</div>
    				<div>
    					<a class="title text-orange left"><?=$plano['titulo']?></a>
    					<p class="plan-description small-text text-gray"><?=html_entity_decode($plano['descricao'])?></p>
    				</div>
    				<div>
    					<div>
    						<a class="plan-name text-orange left"><?=($assinatura['vip'] ? 'VIP' : 'Básico')?></a>
    						<a class="plan-price text-orange left">R$ <?=($assinatura['vip'] ? number_format($plano['valor_vip']/100,2,',','.') : number_format($plano['valor_basico']/100,2,',','.') )?><span class="month text-orange">/mês</span></a>
                            <?if($assinatura && !$assinaturaAtiva):?>
                                <div class="pagar-wrapper">
                                    <a href="/pagamento/<?=$assinatura['id']?>" class="btn orange btn-small orange-hover">Efetuar Pagamento</a>
                                </div>
                                <div class="cancelar-wrapper">
                                    <a href="javascript:void(0)" class="btn-cancelar">Cancelar Assinatura</a>
                                </div>
                            <?endif;?>
                        </div>
    				</div>
    			</div>
    		</div>
    	</div>
        <?if($minhasFaturas):?>
    	<div class="col-table-plans">
	    	<table class="responsive-table">
        	<thead>
            	<tr>
                	<th>ID</th>
                	<th>Plano</th>
                	<th>Valor Total</th>
                	<th>Data Vencimento</th>
                	<th>Pagar</th>
            	</tr>
        	</thead>
        	<tbody>
            	<?foreach($minhasFaturas as $i => $fatura):?>
                	<tr>
                    	<td>#<?=$fatura['id']?></td>
                    	<td><?=$fatura['plano']?></td>
                    	<td>R$<?=number_format($fatura['valor']/100, 2, ',', '.')?></td>
                    	<td><?=$fatura['data_formatada']?></td>
                    	<td><?=(!$fatura['pago'] ? '<a href="/pagamento/'.$fatura['id'].'" class="btn btn-pagar orange"">pagar</a>' : '-')?></td>
                	</tr>
            	<?endforeach;?>
        	</tbody>
	    	</table>
    	</div>
        <?endif;?>
		</div>
	<?endif;?>
</section>


<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/minha-conta.css" type="text/css" rel="stylesheet" media="screen"/>';
    $scriptPage = '<script src="'.URL_SITE.'assets/js/pages/minha-conta.js"></script>';
?>