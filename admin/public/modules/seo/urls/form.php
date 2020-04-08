<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php');
	
	necessitaLogin();
	
	$nomeModulo = "Seo URL";
	$pathModulo	= URL_ADMIN."public/modules/seo/urls/";	
	
	//$id = $_REQUEST["id"];
	
	$class = new SeoUrl;
	
	$url = $class->getById($id);
		
	$origemURL = ($_REQUEST["urlOrigem"] == "" ? $url['origem'] : $_REQUEST["urlOrigem"]);
	
	$registro = $class->getByOrigem($origemURL);
	$id = end($registro)['id'];
	$url = $class->getById($id);
?>	

<div class="seo-form">
		
	<script type="text/javascript" src="<?=$pathModulo?>form.js"></script>
	
	<div class="modal-title">
		<h1><?=($id ? "Editar" : "Criar")?> <?=$nomeModulo?></h1>
	</div>
	<div class="modal-content modal-fixed-footer">
    	
		<form action="<?=$pathModulo?>ajax.php" id="modal" data-datatable="true">
			<input type="hidden" value="<?=$id?>" name="id"/>
<!-- 			<input type="hidden" value="<?=$origemURL?>" name="origem"/> -->
			<input type="hidden" value="<?=($id ? "editar" : "criar")?>" name="acao"/>
			
			<div class="row">
				<div class="input-field col s12">
					<input id="origem" type="text" readonly="<?=($_REQUEST["urlOrigem"] == "" ? false : true)?>" value="<?=$origemURL?>" required name="dados[origem]">
					<label for="origem" class="active">
						<span class="truncate">Página Origem*</span>
					</label>
				</div>
				<div class="input-field col s12">
					<input id="destino" type="text" value="<?=$url['destino']?>" name="dados[destino]">
					<label for="destino" class="active">
						<span class="truncate">Página Destino *</span>
					</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>