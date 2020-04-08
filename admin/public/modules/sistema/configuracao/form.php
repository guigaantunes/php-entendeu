<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class = new Configuracao;
	
	$nomeModulo = "Configuração";
	$pathModulo	= getUrlTo(__FILE__);
	
	$id = $_REQUEST["id"];
	$registro = $class->getById($id);


?>	

<div class="usuario-form">
		
	<script type="text/javascript" src="<?=$pathModulo?>form.js"></script>
	
	<div class="modal-title">
		<h1><?=($id ? "Editar" : "Criar")?> <?=$nomeModulo?></h1>
	</div>
	<div class="modal-content modal-fixed-footer">
		<form action="<?=$pathModulo?>ajax.php" id="modal" data-update="false" data-datatable="true">
			<input type="hidden" value="<?=$id?>" name="id"/>
			<input type="hidden" value="<?=($id ? "editar" : "criar")?>" name="acao"/>
			
			<div class="row">
				<div class="input-field col s12 m12">
					<input id="email_contato" type="text" value="<?=$registro["email_contato"]?>" required name="dados[email_contato]" maxlenght="255">
					<label for="email_contato" class="active">
						<span class="truncate">E-mail de Contato *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m12">
					<input id="youtube" type="text" value="<?=$registro["youtube"]?>" required name="dados[youtube]" maxlenght="255" placeholder="https://youtube.com/">
					<label for="youtube" class="active">
						<span class="truncate">Youtube *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m12">
					<input id="facebook" type="text" value="<?=$registro["facebook"]?>" required name="dados[facebook]" maxlenght="255" placeholder="https://facebook.com/">
					<label for="facebook" class="active">
						<span class="truncate">Facebook *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m12">
					<input id="instagram" type="text" value="<?=$registro["instagram"]?>" required name="dados[instagram]" maxlenght="255" placeholder="https://instagram.com/">
					<label for="instagram" class="active">
						<span class="truncate">Instagram *</span>
					</label>
				</div>
				
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" id="btn-salva-conteudo" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>