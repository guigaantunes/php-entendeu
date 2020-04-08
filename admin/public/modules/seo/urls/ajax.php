<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new SeoUrl;
		
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
				
				$urlDestino = $class->getByDestino($dados['destino']);

								
				if (!empty($urlDestino) AND $urlDestino['origem'] != $dados['origem'] AND $dados['destino'] != '') {
					$Resposta->insert('Destino já existe', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				if (empty($dados['origem'])) {
					$Resposta->insert('Preencha a origem.', Resposta::ERROR);
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
				$urlDestino = $class->getByDestino($dados['destino']);
				$origem = $_POST['origem'];
				
	
				if (is_array($urlDestino) AND !empty($urlDestino) AND $urlDestino['origem'] != $dados['origem'] AND $dados['destino'] != '') {
					$Resposta->insert('Destino já existe', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				if (empty($dados['origem'])) {
					$Resposta->insert('Preencha a origem.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
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