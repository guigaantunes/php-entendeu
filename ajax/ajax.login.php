<?php
    
    session_start();
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
    
     
    $classResposta  = new Resposta;
    $class          = new Cliente;
    
    //$Resposta::$autoprint = false;
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuario = $class->login($email, $senha);
	//var_dump($usuario);
	if($usuario){
		session_start();
		//var_dump($_SESSION);
		$_SESSION['cliente'] = array(
			'id'        => $usuario['id'],
			'nome'      => $usuario['nome'],
			'email'     => $usuario['email'],
			'telefone'  => $usuario['telefone']
		);
		//var_dump($_SESSION);
		if ($_REQUEST["lembrar"]) {
			setcookie("lembrarEmail", $_SESSION['cliente']["email"], strtotime( '+30 days' ), '/');
		} else {
			setcookie("lembrarEmail", $_SESSION['cliente']["email"], time() - 36000, '/');
		}
		
		$classResposta->insert('Login efetuado com sucesso.', Resposta::SUCCESS);
	} else {
		$classResposta->insert('Erro na tentativa de login.', Resposta::ERROR);
		$classResposta->insert('Dados não conferem.', Resposta::ERROR);
		$classResposta->setStatus(false);
	}