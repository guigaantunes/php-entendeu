<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class = new Materia;
// 	$classDisciplina = new Disciplina;
	
	$nomeModulo = "Matéria";
	$pathModulo	= getUrlTo(__FILE__);
	
	$id = $_REQUEST["id"];
	$registro = $class->getById($id);
	
	$idDisciplina = $_REQUEST['idDisciplina'];


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
			<input type="hidden" value="<?=$idDisciplina?>" name="dados[id_disciplina]"/>
			
			<div class="row">
				<div class="input-field col s12 m12">
					<input id="titulo" type="text" value="<?=$registro["titulo"]?>" required name="dados[titulo]" maxlenght="255">
					<label for="titulo" class="active">
						<span class="truncate">título *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m12">
					<input id="ordem" type="number" value="<?=($id ? $registro["ordem"] : $class->nextOrder($idDisciplina))?>" required name="dados[ordem]">
					<label for="ordem" class="active">
						<span class="truncate">Ordem *</span>
					</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" id="btn-salva-conteudo" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>