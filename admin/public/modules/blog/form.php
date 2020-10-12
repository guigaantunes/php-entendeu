<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class          = new Blog;
	$classCategoria = new CategoriaBlog;
	$classMateria = new Materia;
/*
	$classTopico = new Topico;
	$classMateria = new Materia;
	$classDisciplina = new Disciplina;
*/
	
	$nomeModulo = "Blog";
	$pathModulo	= getUrlTo(__FILE__);
	
	$id = $_REQUEST["id"];
	$registro = $class->getBy(
	    $dados = array(
    	    'blog.id' => $id
	    ),
	    $campos = array(
    	    'blog.*'
	    )
	);
	$registro = end($registro);
	
	$categorias = $classCategoria->listAll();
	$materias = $classMateria->getBy(
		$dados = array(
			'status' => 1
		)
	);
	
/*
	$disciplinas = $classDisciplina->listAll();
	
	if ($id) {
    	$materias = $classMateria->getBy(
        	$dados = array(
        	    'status' => 1,
        	    'id_disciplina' => $registro['id_disciplina']
            )
    	);
    	
    	$topicos = $classTopico->getBy(
        	$dados = array(
        	    'status' => 1,
        	    'id_materia' => $registro['id_materia']
            )
    	);
    	
	} else {
    	
	}
*/

    //$topicos = $classTopico->listAll();
?>	

<div class="usuario-form">
		<?//var_dump($registro)?>
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
					<input id="titulo" type="text" value="<?=$registro["titulo"]?>" required name="dados[titulo]" maxlenght="255">
					<label for="titulo" class="active">
						<span class="truncate">título *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<input id="url" type="text" value="<?=$registro["url"]?>" required name="dados[url]" maxlenght="255">
					<label for="url" class="active">
						<span class="truncate">url *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<select id="categoria" class="select2 required" name="dados[id_categoria]" required>
    					<option value="" disabled>Selecione uma opção...</option>
    					<?foreach($categorias as $i => $categoria):?>
    					    <option value="<?=$categoria['id']?>" <?=($categoria['id'] == $registro['id_categoria'] ? 'selected' : '')?> ><?=$categoria['titulo']?></option>
    					<?endforeach;?>
					</select>
					<label for="categoria" >
						<span >Categoria *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<select id="materia" class="" name="dados[id_materia]" required>
    					<option value="" disabled>Selecione uma opção...</option>
    					<?foreach($materias as $i => $materia):?>
    					    <option value="<?=$materia['id']?>" <?=($materia['id'] == $registro['id_materia'] ? 'selected' : '')?> ><?=$materia['titulo']?></option>
    					<?endforeach;?>
					</select>
					<label for="materia" >
						<span >Matéria *</span>
					</label>
				</div>
				
<!--
				<div class="input-field col s12 m4">
					<select id="materia" class="select2 required" required>
    					<option value="" disabled>Selecione uma opção...</option>
    					<?foreach($materias as $i => $materia):?>
    					    <option value="<?=$materia['id']?>" <?=($materia['id'] == $registro['id_materia'] ? 'selected' : '')?> ><?=$materia['titulo']?></option>
    					<?endforeach;?>
					</select>
					<label for="materia" >
						<span >Matéria *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m4">
					<select id="topico" class="select2 required" name="dados[id_topico]" required>
    					<option value="" disabled>Selecione uma opção...</option>
    					<?foreach($topicos as $i => $topico):?>
    					    <option value="<?=$topico['id']?>" <?=($topico['id'] == $topico['id_topico'] ? 'selected' : '')?> ><?=$topico['titulo']?></option>
    					<?endforeach;?>
					</select>
					<label for="topico" >
						<span >Tópico *</span>
					</label>
				</div>
-->
				
<!--
				<div class="input-field col s12 m6">
					<select id="topico" class="required" required name="dados[id_topico]">
    					<option value="" disabled>Selecione uma opção...</option>
    					<?foreach($topicos as $i => $topico):?>
    					    <option value="<?=$topico['id']?>" <?=($topico['id'] == $registro['id_topico'] ? 'selected' : '')?> ><?=$topico['titulo']?></option>
    					<?endforeach;?>
					</select>
					<label for="topico" >
						<span >Tópico *</span>
					</label>
				</div>
-->
				
                <div class="col s12">
                	<h3><label for="texto">conteúdo *</label></h3>
                    <textarea required class="froala required" id="conteudo" name="dados[conteudo]" maxlength="<?=(1<<16) - 1?>"><?=$registro['conteudo']?></textarea>
                </div>
				
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" id="btn-salva-conteudo" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>