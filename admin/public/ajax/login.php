<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	
	$classResposta = new Resposta;
	
	if (!isCaptchaValid()) {
		$classResposta->insert('Certifique-se de que você não é um robô', Resposta::ERROR);
		$classResposta->setStatus(false);
		return;
	}
	
	$classUsuario = new UsuarioAdmin;
	$usuario = $classUsuario->login($_POST['email'], $_POST['senha']);
	
	if($usuario){
		$_SESSION['admin'] = array(
			'id' => $usuario['id'],
			'nome' => $usuario['nome'],
			'email' => $usuario['email'],
// 			'id_nivel' => $usuario['id_nivel']
		);
		
		if ($_REQUEST["lembrar"]) {
			setcookie("lembrarEmail", $_SESSION['admin']["email"], strtotime( '+30 days' ), '/');
		} else {
			setcookie("lembrarEmail", $_SESSION['admin']["email"], time() - 36000, '/');
		}
		
		$classResposta->insert('Login efetuado com sucesso.', Resposta::SUCCESS);
	} else {
		$classResposta->insert('Erro na tentativa de login.', Resposta::ERROR);
		$classResposta->insert('Dados não conferem.', Resposta::ERROR);
		$classResposta->setStatus(false);
	}
?>