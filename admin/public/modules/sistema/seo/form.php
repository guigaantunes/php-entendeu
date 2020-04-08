<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class = new Seo;
	
	$nomeModulo = "Seo";
	$pathModulo	= getUrlTo(__FILE__);
	
	$origemURL = $_REQUEST["pagina"] . '/' . $_REQUEST["identificador"];
	$pagina = $_REQUEST['pagina'];
	$identificador = $_REQUEST['identificador'];
	
	$dadosRegistro = $class->getByUrl($origemURL);
?>	

<div class="seo-form">
		
	<script type="text/javascript" src="<?=$pathModulo?>form.js"></script>
	
	<div class="modal-title">
		<h1><?=$nomeModulo?> <?=$pagina?></h1>
	</div>
	<div class="modal-content modal-fixed-footer">
		<form action="<?=$pathModulo?>ajax.php" id="modal" data-datatable="true">
			<input type="hidden" value="<?=($dadosRegistro ? "editar" : "criar")?>" name="acao"/>
			<div class="row">
				<div class="input-field col s12">
					<input id="origem" type="text" value="<?=$origemURL?>" required readonly="readonly" name="dados[origem]">
					<label for="origem" class="active">
						<span class="truncate">Página Origem *</span>
					</label>
				</div>
				<div class="input-field col s12">
					<input id="destino" type="text" value="<?=$dadosRegistro['destino']?>" required name="dados[destino]">
					<label for="destino" class="active">
						<span class="truncate">Página Destino *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="meta_tags" type="text" value="<?=$dadosRegistro['meta_tags']?>" name="dados[meta_tags]">
					<label for="meta_tags" class="active">
						<span class="truncate">Meta-Tags</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="meta_title" type="text" value="<?=$dadosRegistro['meta_title']?>" name="dados[meta_title]">
					<label for="meta_title" class="active">
						<span class="truncate">Meta-Title</span>
					</label>
				</div>
				<div class="input-field col s12 m12">
					<input id="meta_description" type="text" value="<?=$dadosRegistro['meta_description']?>" name="dados[meta_description]">
					<label for="meta_description" class="active">
						<span class="truncate">Meta-Description</span>
					</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>