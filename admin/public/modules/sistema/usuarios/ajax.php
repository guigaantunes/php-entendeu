<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new UsuarioAdmin;
	$modulo = "usuarios";	
		
	if($_GET){
		
		$resgistros = $class->getBy(array(
			'status' => 1
		),
		array(
			'*',
			'id AS DT_RowId'
		));
		echo data($resgistros);
	}
	
	if($_POST){
		
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
		filterArray(array('nome', 'email', 'senha', 'id_nivel'), $dados);
				
		switch ($acao) {
			case 'criar' :
				
				list($usuarios) = $class->getBy(array(
					'status'	=>	1,
					'email'		=> $dados['email']
				));
				
				if (sizeof($usuarios) > 0) {
					$Resposta->insert('Já existe um usuário com esse email', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$success = $class->insert($dados);
				
				if(!$success) {
					$Resposta->insert('Erro ao criar usuário.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Usuário criado com sucesso.', Resposta::SUCCESS);	
				break;
			case 'editar' :
				
				list($usuarios) = $class->getBy(array(
					'status'	=>	1,
					'email'		=> $dados['email']
				));
				
				if ($usuarios AND @$usuarios['id'] != $_POST["id"]) {
					$Resposta->insert('Já existe um usuário com esse email', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				if($dados["senha"] == "") {
					unset($dados["senha"]);	
				}
				
				$success = $class->update($_POST["id"], $dados);
				
				if(!$success) {
					$Resposta->insert('Erro ao editar usuário.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Usuário alterado com sucesso.', Resposta::SUCCESS);				
				break;
			case 'excluir' :
				
				$success = $class->deleteById($_POST["id"]);
				
				if(!$success) {
					$Resposta->insert('Erro na tentativa de exclusão.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Usuário excluído com sucesso.', Resposta::SUCCESS);
				break;
		}			
	}
	
?>