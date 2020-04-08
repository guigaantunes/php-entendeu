<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$nomeModulo = "Seo Meta";
	$pathModulo	= URL_ADMIN."public/modules/seo/metas/";	
	
	$class = new SeoMeta;
 
  
  
	
// 	$dadosRegistro = $class->get();

		$id = $_REQUEST["identificador"];
		$retorno = $class->dados($id);
    $meta = $retorno[0];

?>	

<div class="imoveis-tipo-form">
		
	<script type="text/javascript" src="<?=$pathModulo?>form.js"></script>
	
	<div class="modal-title">
		<?php if ($_REQUEST["pagina"] == "" && $_REQUEST["identificador"] == "") { ?>
		<h1><?=($id ? "Editar" : "Criar")?> <?=$nomeModulo?></h1>
		<?php } else { ?>
		<h1><?=(empty($meta) ? "Criar" : "Editar")?> <?=$nomeModulo?></h1>
		<?php } ?>
	</div>
	<div class="modal-content modal-fixed-footer">
		<form action="<?=$pathModulo?>ajax.php" id="modal" data-datatable="true">
			<input type="hidden" value="<?=$id?>" name="id"/>
			<div class="row">
			    <?php if ($_REQUEST["pagina"] == "" && $_REQUEST["identificador"] == "") { ?>
			    <input type="hidden" value="<?=($id ? "editar" : "criar")?>" name="acao"/>
				<div class="input-field col s12 m6">
					<input id="pagina" type="text" value="<?=$meta['pagina']?>" required>
					<label for="pagina" class="active">
						<span class="truncate">Página *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="identificador" type="text" value="<?=$meta['identificador']?>" required>
					<label for="identificador" class="active">
						<span class="truncate">Identificador *</span>
					</label>
				</div>
				<?php } else { ?>
					<input type="hidden" value="<?=($meta == array() ? "criar" : "editar")?>" name="acao"/>
					<div class="input-field col s12 m6">
						<input id="pagina" type="text" value="<?=$_REQUEST['pagina']?>" required readonly name="dados[pagina]">
						<label for="pagina" class="active">
							<span class="truncate">Página *</span>
						</label>
					</div>
					<div class="input-field col s12 m6">
						<input id="identificador" type="text" value="<?=$_REQUEST['identificador']?>" required readonly name="dados[identificador]">
						<label for="identificador" class="active">
							<span class="truncate">Identificador *</span>
						</label>
					</div>
				<?php } ?>
				<div class="input-field col s12 m6">
					<input id="meta_tag" type="text" value="<?=$meta['meta_tag']?>" name="dados[meta_tag]">
					<label for="meta_tag" class="active">
						<span class="truncate">Tags</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="meta_title" type="text" value="<?=$meta['meta_title']?>" name="dados[meta_title]">
					<label for="meta_title" class="active">
						<span class="truncate">Titulo</span>
					</label>
				</div>
				<div class="input-field col s12 m12">
					<input id="meta_description" type="text" value="<?=$meta['meta_description']?>" name="dados[meta_description]">
					<label for="meta_description" class="active">
						<span class="truncate">Descrição</span>
					</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>