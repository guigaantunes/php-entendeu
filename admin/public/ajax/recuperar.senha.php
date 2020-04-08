<?php	
	
	include("../includes/default.php");
	
	includeClasses('Resposta', 'Connection', 'Email');
	
	$Resposta = new Resposta;
	$UsuarioAdmin = new UsuarioAdmin;
	
	list($admin) = $UsuarioAdmin->getBy(array('email' => $_REQUEST["email"], 'status' => 1));
	
	$novaSenha = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
			
	if(!$admin) {
		$Resposta->insert('Email não registrado', Resposta::ERROR);
		die();
	}
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$admin['nome'].' <'.$_REQUEST["email"].'>' . "\r\n";
	$headers .= 'From: '.NOME_EMPRESA.' <'.EMAIL_PRINCIPAL.'>' . "\r\n";
	
	$Email = new Email;
	
	$sucessMail = $Email->genericEmail(
		array($_REQUEST["email"] => $admin['nome']), 
		'Recuperar Senha', 
		'Olá, '.$admin['nome'].'.<br>
		<br> 
		Foi solicitada uma nova senha para sua conta de administrador no site '.NOME_EMPRESA.'. Sua nova senha é <b>'.$novaSenha.'</b><br>
		<br>
		Tenha um bom dia!'
	);
	
	if(!$sucessMail) {
		$Resposta->insert('Não foi possível enviar uma nova senha para o email', Resposta::ERROR);
		$Resposta->insert('Tente novamente', Resposta::ERROR);
		die();
	}
	
	$sucessEdit = $UsuarioAdmin->update($admin['id'], array("senha" => $novaSenha));	
	
	if (!$sucessEdit) {
		$Resposta->insert('Não foi possível definir nova senha.', Resposta::ERROR);
		$Resposta->insert('Ignore seu email', Resposta::ERROR);
		die();
	}
	
	$Resposta->insert('Sua nova senha foi enviada para o e-mail solicitado.', Resposta::SUCCESS);

?>