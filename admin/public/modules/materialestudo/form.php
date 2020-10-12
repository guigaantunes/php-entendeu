<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class = new MaterialEstudo;
// 	$classTopico = new Topico;
	$classMateria = new Materia;
	$classDisciplina = new Disciplina;
	
	$nomeModulo = "Material de Estudo";
	$pathModulo	= getUrlTo(__FILE__);
	
	$id = $_REQUEST["id"];
	$registro = $class->getBy(
	    $dados = array(
    	    'materialestudo.id' => $id
	    ),
	    $campos = array(
    	    'materialestudo.*',
    	    'disciplina.id as id_disciplina'
//     	    'materia.id as id_materia'
	    ),
	    $inner = array(
/*
    	    'topico' => array(
        	    'topico.id' => 'materialestudo.id_topico'
    	    ),
*/
    	    'materia' => array(
        	    'materia.id' => 'materialestudo.id_materia'
    	    ),
    	    'disciplina' => array(
        	    'disciplina.id' => 'materia.id_disciplina'
    	    )
	    )
	);
	$registro = end($registro);
	
	$disciplinas = $classDisciplina->listAll();
	$materias = $classMateria->getBy(
		$dados = array(
			'status' => 1
		)
	);
	if ($id) {
    	$materias = $classMateria->getBy(
        	$dados = array(
        	    'status' => 1,
        	    'id_disciplina' => $registro['id_disciplina']
            )
    	);
    	
/*
    	$topicos = $classTopico->getBy(
        	$dados = array(
        	    'status' => 1,
        	    'id_materia' => $registro['id_materia']
            )
    	);
*/
    	
	} 

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
				<div class="input-field col s12 m10">
					<input id="titulo" type="text" value="<?=$registro["titulo"]?>" required name="dados[titulo]" maxlenght="255">
					<label for="titulo" class="active">
						<span class="truncate">título *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m2">
					<input id="titulo" type="number" value="<?=$registro["ordem"]?>" required name="dados[ordem]" maxlenght="3">
					<label for="titulo" class="active">
						<span class="truncate">Ordem *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m12">
					<input id="video" type="text" value="<?=$registro["video"]?>" name="dados[video]" maxlenght="255">
					<label for="video" class="active">
						<span class="truncate">vídeo</span>
					</label>
				</div>

				<div class="input-field col s12 m6">
					<select id="disciplina" class="select2 required" required>
    					<option value="" disabled>Selecione uma opção...</option>
    					<?foreach($disciplinas as $i => $disciplina):?>
    					    <option value="<?=$disciplina['id']?>" <?=($disciplina['id'] == $registro['id_disciplina'] ? 'selected' : '')?> ><?=$disciplina['titulo']?></option>
    					<?endforeach;?>
					</select>
					<label for="disciplina" >
						<span >Disciplina *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<select id="materia" class="select2 required" name="dados[id_materia]" required>
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
				
				
                <div class="col s12">
                	<h3><label for="texto">conteúdo *</label></h3>
                    <textarea required class="froala required" id="conteudo" name="dados[conteudo]" maxlength="<?=(1<<16) - 1?>"><?=$registro['conteudo']?></textarea>
                </div>
                
               
			</div>
			
			 <div class="row" >
                    <div class="col s12">
                        <h3>É Demonstrativo?</h3>
                    </div>
                    <div class="col s12">
                        <div class="switch">
                            <label>
                                NÃO
                                <input type="checkbox" id="demonstrativo" name="dados[demonstrativo]" <?=($registro['demonstrativo'] ? 'checked' : '')?> >
                                <span class="lever"></span>
                                SIM
                            </label>
                        </div>
                    </div>
                </div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" id="btn-salva-conteudo" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>