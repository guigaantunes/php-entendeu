<?php
	
	session_start();
		
	require('../includes/default.php');
	require('../modules/sistema/usuarios/class.php');
	
	$nomeModulo = "Usuário";
	$pathModulo	= URL_ADMIN."public/modules/sistema/usuarios/";	
	
	$id = $_REQUEST["id"];
	
	$class = new Usuario();
	$class->id = $id;

	$usuario = $class->get();
	
?>	

<div class="usuario-form">
		
	<script type="text/javascript" src="<?=$pathModulo?>form.js"></script>
	
	<div class="modal-title">
		<h1><?=($id ? "Editar" : "Criar")?> <?=$nomeModulo?></h1>
	</div>
	<div class="modal-content modal-fixed-footer">
		<form>
			<input type="hidden" value="<?=$id?>" name="id"/>
			<input type="hidden" value="<?=($id ? "editar" : "criar")?>" name="acao"/>
			
			<div class="row">
				<div class="input-field col s12 m6">
					<input id="nome" type="text" placeholder="" class="required" value="<?=$usuario["nome"]?>" required name="nome">
					<label for="nome" class="active">
						<span class="truncate">Nome <? print($id); ?>>*</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="email" type="text" placeholder="" class="required" value="<?=$usuario["email"]?>" required name="email">
					<label for="email" class="active">
						<span class="truncate">Email *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="senha" type="password" placeholder="" class="<?=$id ? "" : "required"?>" name="senha">
					<label for="senha" class="active">
						<span class="truncate"><?=$id ? "Nova " : ""?>Senha *<?=$id ? '<i class="material-icons help tooltipped" data-position="bottom" data-delay="50" data-tooltip="Só será modificada com o preenchimento dos campos.">&#xE8FD;</i>' : "" ?></span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="csenha" type="password" placeholder="" class="<?=$id ? "" : "required"?>" name="csenha">
					<label for="csenha" class="active">
						<span class="truncate">Confirmar <?=$id ? "Nova " : ""?>Senha *</span>
					</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>