<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class = new Plano;
	
	$nomeModulo = "Plano";
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
    			<div class="ballon-alert warning-important">
            		<div class="icon">
            			<i class="material-icons"></i>
            			<h2>Aviso</h2>
            		</div>
            		<div class="text">
                		<h2>Atenção!</h2>
            			<p> Os dados aqui alterados devem ser igualmente ajustados no PagSeguro. Dessa forma, é possível garantir a corretude quanto às faturas geradas para os clientes!</p>
            		</div>
            	</div>
    			    			
				<div class="input-field col s12 m6">
					<input id="titulo" type="text" placeholder="" class="required" value="<?=$registro["titulo"]?>" required name="dados[titulo]">
					<label for="titulo" class="active">
						<span class="truncate">Título *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m3">
					<input id="meses" type="number" min="1" placeholder="" class="required" value="<?=$registro["meses"]?>" required name="dados[meses]">
					<label for="meses" class="active"> 
						<span class="truncate">Meses *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m3">
					<input id="ordem" type="number" min="0" placeholder="" class="required" value="<?=($id ? $registro["ordem"] : $class->nextOrder())?>" required name="dados[ordem]">
					<label for="ordem" class="active">
						<span class="truncate">Ordem *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<input id="valor_basico" type="text" placeholder="" class="mask-money required" value="<?=$registro["valor_basico"]?>" required name="dados[valor_basico]">
					<label for="valor_basico" class="active">
						<span class="truncate">Valor Básico *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<input id="valor_vip" type="text" placeholder="" class="mask-money required" value="<?=$registro["valor_vip"]?>" required name="dados[valor_vip]">
					<label for="valor_vip" class="active">
						<span class="truncate">Valor VIP *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<input id="pagseguro_codigo_basico" type="text" placeholder="" class="" value="<?=$registro["pagseguro_codigo_basico"]?>"  name="dados[pagseguro_codigo_basico]">
					<label for="pagseguro_codigo_basico" class="active">
						<span class="truncate">Código plano básico (PAGSEGURO)</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<input id="pagseguro_codigo_vip" type="text" placeholder="" class="" value="<?=$registro["pagseguro_codigo_vip"]?>"  name="dados[pagseguro_codigo_vip]">
					<label for="pagseguro_codigo_vip" class="active">
						<span class="truncate">Código plano VIP (PAGSEGURO)</span>
					</label>
				</div>
				
				
				<div class="col s12 m12">
    				<h3><label for="descricao">conteúdo *</label></h3>
    				
					<textarea id="descricao" type="text" placeholder="" class="froala required" required name="dados[descricao]" ><?=$registro['descricao']?></textarea>
				</div>
				
				<div class="col s12 m12">
    				<h3><label for="termos">Termos *</label></h3>
    				
					<textarea id="termos" type="text" placeholder="" class="froala required" required name="dados[termos]" ><?=$registro['termos']?></textarea>
				</div>
				
				<div class="col s12 m12">
    				<h3><Label>Status do plano</Label></h3>
    				<div class="switch">
                        <label>
                            Inativo
                            <input type="checkbox" name="dados[ativo]" <?=$registro['ativo'] == 1 ? 'checked' : ''?> >
                            <span class="lever"></span>
                            Ativo
                        </label>
                    </div>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>