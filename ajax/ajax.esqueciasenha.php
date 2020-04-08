<?php
    
    session_start();
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
    
     
    $classResposta  = new Resposta;
    $class          = new Cliente;
    
    //$Resposta::$autoprint = false;
    
    $email = $_GET['email'];

	$usuario = end($class->getBy(['email' => $email]));
	
	if($usuario){
		# GERAR SENHA
		$novaSenha = randomPassword(6);
		
		# ATUALIZAR
		$usuario['senha'] = md5($novaSenha);
		$class->update($usuario["id"], $usuario);
		
		# MENSAGEM
		$mensagem = "
			<div style='width:100%; height: 50px; background-color: rgb(0,0,0,0.3); text-align: center;'>
				<p style='margin: auto; font-size: 18px; line-height: 50px; color: #FFF'> Prezado ". $usuario['nome']. ", segue sua nova senha:</p>
			</div>
			<br/>
			<div style='margin: auto; min-height: 20px; text-align: center; width: 100%;'>
				<p>Sua Nova Senha: </p>
				<br/>
				<p style='font-size: 30px;'><strong>".$novaSenha."</strong></p>
			</div>
		"; 
		
		#HEADERS PARA O EMAIL 
		
		$subDominioEmail = substr(URL_SITE, 12);
		
		$headers = "From: ".NOME_EMPRESA." - Nova Senha <noreply@". $subDominioEmail ."> \r\n";
		$headers .= "Reply-To: noreply@entendeudireito.com \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
		# MANDA EMAIL
		
		$result = mail($usuario['email'], NOME_EMPRESA." - Nova Senha", $mensagem, $headers);
		
		if($result === TRUE){
			$classResposta->insert('Senha enviada com sucesso.', Resposta::SUCCESS);
			$classResposta->insert('Verifique sua caixa de entrada, e caixa spam.', Resposta::SUCCESS);
		}else{
			mail('guilherme.evangelista@entendeudireito.com.br', "Erro Nova Senha". NOME_EMPRESA, "Erro no envio da nova senha");
			$classResposta->insert('Algo errado aconteceu', Resposta::ERROR);
			$classResposta->insert('Tente novamente mais tarde.', Resposta::ERROR);
		}
		
	} else {
		
		$classResposta->insert('Usuario nao encontrado', Resposta::ERROR);
		$classResposta->insert('Veirifique seu email.', Resposta::ERROR);
		
		$classResposta->setStatus(false);
	}