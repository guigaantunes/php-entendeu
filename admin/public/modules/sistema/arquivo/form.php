<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class = new Arquivo;
	
	$nomeModulo = "Gerenciar Imagens";
	$pathModulo	= getUrlTo(__FILE__);	
	
	$id = $_REQUEST["id"];
	$tabela = $_REQUEST["tabela"];
	$tipo = $_REQUEST["tipo"];
	
	$pesquisarPor = array(
		'tabela'		=> $tabela,
		'id_referencia'	=> $id
	);
	
	if ($tipo)
		$pesquisarPor['tipo'] = $tipo;
		
	$arquivos = $class->getBy($pesquisarPor);
?>	

<div class="usuario-form">
	<script type="text/javascript">
		var urlImagens = '<?=URL_SITE . "assets/dinamicos/$tabela/$id/$tipo/"?>';
	</script>
	<script type="text/javascript" src="<?=$pathModulo?>form.js"></script>
	
	<div class="modal-title">
		<h1><?=($tipo == 'Arquivo')?"Gerenciar Arquivos":$nomeModulo?></h1>
	</div>
	<div class="modal-content modal-fixed-footer">
		<div class="row">
			<form action="<?=$pathModulo?>ajax.php" class="dropzone">
				<input type="hidden" value="<?=$id?>" name="dados[id_referencia]"/>
				<input type="hidden" value="<?=$tabela?>" name="dados[tabela]"/>
				<input type="hidden" value="<?=$tipo?>" name="dados[tipo]"/>
				<input type="hidden" name="id" value="<?=$id?>">
			</form>
		</div>
		<form action="<?=$pathModulo?>ajax.php" id="modal">
			<input type="hidden" name="acao" value="ordem">
			<ul class="collapsible" data-collapsible="expandable">
				<li>
					<div class="collapsible-header <?=!empty($arquivos) ? "active" : ""?>"><?=($tipo == 'Arquivo')?"Gerenciar Arquivos":"Imagens Cadastradas"?></div>
					<div class="collapsible-body">
						<ul class="collection images-list">
							<?php 
    							foreach($arquivos as $index => $valorFoto) : 
    							    //$ext = pathinfo($filename, PATHINFO_EXTENSION);
							?>
								<li class="collection-item avatar" id="<?=$valorFoto["id"]?>">
									<?php if(strtolower($tipo) != 'arquivo'): ?>
									    <img src="<?=URL_SITE . "assets/dinamicos/$tabela/$id/$tipo/g" . $valorFoto['id'] .  $valorFoto['arquivo']?>" alt="<?=$valorFoto['titulo']?>" class="circle large">
									<?php else: ?>
    									<div class="circle large" style="width: 70px;height: 70px; background: #c5c5c5; display: flex; align-items: center; justify-content: center"><i class="material-icons white-text">insert_drive_file</i></div>
    									<a target="_blank" style="float: left; margin-top: 22px;" href="<?=URL_SITE . "assets/dinamicos/$tabela/$id/$tipo/g" . $valorFoto['id'] .  $valorFoto['arquivo']?>"><?=$valorFoto['arquivo']?></a>
									<?php endif; ?>
									<div class="row">
										<div class="acoes col s1 right right-align">
											<a class="btn-flat waves-effect waves-darken tooltipped excluirFoto" data-position="bottom" data-delay="50" data-tooltip="Excluir"><i class="material-icons">&#xE872;</i></a>
										</div>
									</div>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>