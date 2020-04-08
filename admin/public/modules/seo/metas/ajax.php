<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new SeoMeta;
		
	if($_GET){
		$class->where = 'status != 0';
		$resgistros = $class->listar();
		echo data($resgistros);
	}
	
	if($_POST){
		
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
						
		switch ($acao) {
			case 'criar' :
/*
				$enabledFields = array('meta_title', 'meta_tag', 'meta_description', 'pagina', 'identificador');
				filterArray($enabledFields, $dados);
				
*/
				if (empty($dados['pagina'])) {
					$Resposta->insert('Preencha a página.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				if (empty($dados['identificador'])) {
					$Resposta->insert('Preencha o identificador.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}

				$success = $class->insert($dados, false);
				if(!$success) {
					$Resposta->insert('Erro ao criar.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Registrado com sucesso.', Resposta::SUCCESS);	
				break;
			case 'editar' :
// 				$enabledFields = array('meta_tag', 'meta_title', 'meta_description');
// 				filterArray($enabledFields, $dados);
				
				
				$class->id = $_POST["id"];
				$success = $class->insert($dados, false);
				
				if(!$success) {
					$Resposta->insert('Erro ao editar.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Alterado com sucesso.', Resposta::SUCCESS);				
				break;
			case 'excluir' :
				$class->id = $_POST["id"];
				$usuario = $class->get();
				
				$success = $class->delete();
				
				if(!$success) {
					$Resposta->insert('Erro na tentativa de exclusão.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Excluído com sucesso.', Resposta::SUCCESS);
				break;
		}
		
	}
	
?>