<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	necessitaLogin();
	
	$class      = new Cliente;
	$classPlano = new Plano;
	
	$nomeModulo = "Clientes";
	$pathModulo	= getUrlTo(__FILE__);	
	
	$id = $_REQUEST["id"];
	$registro = $class->getById($id);
	
	$planos = $classPlano->listAll();
	
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
        			<h3>DADOS DA CONTA</h3>
    			</div>
    			
				<div class="input-field col s12 m6">
					<input id="nome" type="text" placeholder="" class="required" value="<?=$registro["nome"]?>" required name="dados[nome]">
					<label for="nome" class="active">
						<span class="truncate">Nome *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="email" type="text" placeholder="" class="required" value="<?=$registro["email"]?>" required name="dados[email]" >
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
					<input id="csenha" type="password" placeholder="" class="<?=$id ? "" : "required"?>" data-confirm="senha" name="dados[csenha]">
					<label for="csenha" class="active">
						<span class="truncate">Confirmar <?=$id ? "Nova " : ""?>Senha<?=!$id ? " *" : ""?></span>
					</label>
				</div>
				
				<div class="input-field col s12 m12">
        			<h3>DADOS PESSOAIS</h3>
    			</div>
                
				<div class="input-field col s12 m6">
					<input id="telefone" type="text" placeholder="" class="mask-telefone" value="<?=$registro["telefone"]?>" name="dados[telefone]">
					<label for="telefone" class="active">
						<span class="truncate">Telefone</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="celular" type="text" placeholder="" class="mask-telefone" value="<?=$registro["celular"]?>" name="dados[celular]">
					<label for="celular" class="active">
						<span class="truncate">Celular</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="cpf" type="text" placeholder="" class="mask-cpf cpf required" value="<?=$registro["cpf"]?>" required name="dados[cpf]">
					<label for="cpf" class="active">
						<span class="truncate">CPF *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="cep" type="text" placeholder="" class="mask-cep cep required" value="<?=$registro["cep"]?>" required name="dados[cep]">
					<label for="cep" class="active">
						<span class="truncate">CEP *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6" style="clear: left">
					<input id="endereco" data-cep="street" type="text" placeholder="" class="required" value="<?=$registro["endereco"]?>" required name="dados[endereco]">
					<label for="endereco" class="active">
						<span class="truncate">Endereco *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<input id="numero" type="number" min="0" class="required" value="<?=$registro["numero"]?>" required name="dados[numero]">
					<label for="numero" class="active">
						<span class="truncate">Número *</span>
					</label>
				</div>
				
				<div class="input-field col s12 m6">
					<input id="cidade" data-cep="city" type="text" placeholder="" class="required" value="<?=$registro["cidade"]?>" required name="dados[cidade]">
					<label for="cidade" class="active">
						<span class="truncate">Cidade *</span>
					</label>
				</div>
				<div class="input-field col s12 m6">
					<input id="uf" data-cep="state_min" type="text" placeholder="" class="required" value="<?=$registro["uf"]?>" required name="dados[uf]">
					<label for="uf" class="active">
						<span class="truncate">UF *</span>
					</label>
				</div>
				
                
                <div class="input-field col s12 m12">
        			<h3>Ativação Manual</h3>
    			</div>
				<div class="input-field col s12 m6">
				    <div class="switch">
                        <label>
                            Não 
                            <input type="checkbox" name="dados[ativacao_manual]" id="ativacao_manual" <?=$registro['ativacao_manual'] ? 'checked' : '' ?> >
                            <span class="lever"></span> 
                            Sim
                        </label>
                  </div>
				</div>
				
				<div id="vip-manual">
    				<div class="input-field col s12 m12">
            			<h3>Acesso ao VIP</h3>
        			</div>
    				<div class="input-field col s12 m6">
    				    <div class="switch">
                            <label>
                                Não 
                                <input type="checkbox" name="dados[acesso_vip_manual]" id="acesso_vip_manual" <?=$registro['acesso_vip_manual'] ? 'checked' : '' ?> >
                                <span class="lever"></span> 
                                Sim
                            </label>
                      </div>
    				</div>
				</div>
				
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="btn waves-effect waves-darken cor-admin cor-detalhe shades-text text-white submit"><i class="material-icons left">&#xE161;</i>Salvar</a>
	</div>
</div>