<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class              = new Cliente;
	$classPlano         = new Plano;
	$classAssinatura    = new Assinatura;
	
	$nomeModulo = "Clientes";
	$pathModulo	= getUrlTo(__FILE__);	
	
	$id = $_REQUEST["id"];

	
	$assinatura         = $classAssinatura->getAssinatura($id);
	$assinaturaAtiva    = $classAssinatura->assinaturaAtiva($id);
	
	if ($assinatura) {
    	$plano = $classPlano->getById($assinatura['id_plano']);
    	$data_formatada = DateTime::createFromFormat('Y-m-d H:i:s', $assinatura['data_cadastro'])->format('d/m/Y H:i:s');
	}
?>	

<div class="usuario-form">
	<script type="text/javascript" src="<?=$pathModulo?>form.js"></script>
	
	<div class="modal-title">
		<h1>Informações da Assinatura</h1>
	</div>
	<div class="modal-content">
		<?if ($assinatura && $assinaturaAtiva):?>
		    <div style="display:flex; flex-direction: column">
    		    <span>Plano: <?=$plano['titulo']?></span>
    		    <span>VIP: <?=($assinatura['vip'] ? 'Sim' : 'Não')?></span>
    		    <span>Valor: R$<?=number_format($assinatura['valor']/100, 2, ',', '.')?></span>
    		    <span>Meses: <?=$plano['meses']?></span>
    		    <span>Data Adesão: <?=$data_formatada?></span>
		    </div>
		<?else:?>    
		  <p style="text-align: center;">Este cliente não possui assinatura ativa</p>
		<?endif;?>
	</div>
<!--
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
-->
</div>