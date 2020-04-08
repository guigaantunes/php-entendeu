<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new Seo;
	$idModulo = Modulo::Seo;
	$idNivel = $_SESSION['admin']['id_nivel'];
	
	if($_POST){
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
		
		filterArray(array('origem', 'destino', 'meta_tags', 'meta_description', 'meta_title'), $dados);
		
		switch ($acao) {
			case 'criar' :
				if (!Modulo::havePermission(Modulo::Incluir, $idNivel, $idModulo)) {
					forbidden_ajax();
				}

				$success = $class->insert($dados);
				
				if(!$success) {
					$Resposta->insert('Erro ao cadastrar registro.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					
					break;
				}
				
				$Resposta->insert('Registro cadastrado com sucesso.', Resposta::SUCCESS);
				
				break;
			case 'editar' :
				if (!Modulo::havePermission(Modulo::Alterar, $idNivel, $idModulo)) {
					forbidden_ajax();
				}
				
				list($registro) = $class->getBy(array(
					'origem'	=> $dados['origem']
				));
				$success = $class->update($registro["id"], $dados);
				
				if(!$success) {
					$Resposta->insert('Erro ao editar registro.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Registro alterado com sucesso.', Resposta::SUCCESS);				
				break;
		}			
	}
	
?>