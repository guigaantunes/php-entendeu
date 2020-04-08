<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class = new UsuarioAdmin;
	
	$nomeModulo = "Usuário";
	$pathModulo	= getUrlTo(__FILE__);	
	
	$id = $_REQUEST["id"];
	$dadosUsuario = $class->getById($id);
	
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
				<div class="input-field col s12 m6">
					<input id="nome" type="text" placeholder="" class="required" value="<?=$dadosUsuario["nome"]?>" required name="dados[nome]">
					<label for="nome" class="active">
						<span class="truncate">Nome *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="email" type="text" placeholder="" class="required" value="<?=$dadosUsuario["email"]?>" required name="dados[email]" >
					<label for="email" class="active">
						<span class="truncate">Email *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="senha" type="password" placeholder="" class="<?=$id ? "" : "required"?>" name="dados[senha]">
					<label for="senha" class="active">
						<span class="truncate"><?=$id ? "Nova " : ""?>Senha<?=$id ? '<i class="material-icons help tooltipped" data-position="bottom" data-delay="50" data-tooltip="Só será modificada com o preenchimento dos campos.">&#xE8FD;</i>' : " *" ?></span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="csenha" type="password" placeholder="" class="<?=$id ? "" : "required"?>" data-confirm="senha">
					<label for="csenha" class="active">
						<span class="truncate">Confirmar <?=$id ? "Nova " : ""?>Senha<?=!$id ? " *" : ""?></span>
					</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>