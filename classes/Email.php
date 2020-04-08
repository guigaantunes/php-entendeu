<?php
require_once("PHPMailer.php");
class Email {
	private $phpMailer;
	
	private $host    ; //= PHPMAILER_HOST; // Endereço do servidor SMTP
	private $username; //= PHPMAILER_EMAIL; // Usuário do servidor SMTP
	private $password; //= PHPMAILER_SENHA; // Senha do servidor SMTP

	private $is_gmail = false;
	
	function __construct() {
		$this->anexosPath = $_SERVER['DOCUMENT_ROOT'] . '/carrinho/anexos/';
		$this->initEmail();
	}

	
	function genericEmail($destinatarios, $assunto, $mensagem, $anexos=false) {
		foreach ($destinatarios as $email => $nome) {
    		//var_dump($nome, $email);
			$this->phpMailer->AddAddress($email, $nome);
		}
		
		$this->phpMailer->Subject = (NOME_EMPRESA . ' - ' . $assunto);
		$this->phpMailer->Body = $mensagem;	
		
		if($anexos) {
    		foreach($anexos as $nome => $path) {
        		
        		$this->phpMailer->addAttachment($path, $nome);
    		}
		}
		
		return $this->enviar();
	}
	
	function esqueciSenha($destinatarios, $assunto, $mensagem,$anexos=false) {
		return $this->genericEmail($destinatarios, $assunto, $mensagem, $anexos);
	}
	
	function finalizarCompra($destinatarios, $assunto, $mensagem, $anexos=false) {
		return $this->genericEmail($destinatarios, $assunto, $mensagem, $anexos);
	}
	
	function pedidoCancelado($destinatarios) {
    	
    	$assunto = "Cancelamento de Pedido";

		$mensagem = "
		    Olá,<br><br>
		    
		    Infelizmente, informamos que o seu pedido não foi pago e este foi cancelado.<br>
		    Se necessário, efetue um novo pedido pelo nosso sistema.<br><br>
		    
		    Att.
		";
    	
		return $this->genericEmail($destinatarios, $assunto, $mensagem, $anexos=false);
	}
	
	
	private function enviar() {
    	
		$success = $this->phpMailer->Send();
		if ($success === true)
			return true;
		
		debug_log('EMAIL NÃO PODE SER ENVIADO --> ' . $this->phpMailer->Subject);
		return $this->phpMailer->ErrorInfo;
	}
	
	protected function initEmail(){
    	
  	$this->host       = '';
  	$this->username   = '';
  	$this->password   = '';

		if (!class_exists('PHPMailer'))
			require_once("PHPMailer.php");
		
		$this->phpMailer = new PHPMailer;
		
		$this->phpMailer->IsMail(); // Define que a mensagem será SMTP
		$this->phpMailer->Host      = $this->host; // Endereço do servidor SMTP
		$this->phpMailer->Username  = $this->username; // Usuário do servidor SMTP
		$this->phpMailer->Password  = $this->password; // Senha do servidor SMTP

		$this->phpMailer->From      = $this->username; // Seu e-mail
		$this->phpMailer->FromName  = NOME_EMPRESA; // Seu nome
		$this->phpMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
		
		$this->phpMailer->CharSet = "utf-8"; // Mesmo encode desse arquivo
		
		
		if ($this->is_gmail) {
    		$this->phpMailer->IsSMTP();
    		$this->phpMailer->SMTPAuth  = true; // Usa autenticação SMTP? (opcional)
			$this->phpMailer->SMTPSecure= $config['SMTP_secure'];
			$this->phpMailer->Host      = $this->host;
			$this->phpMailer->Port      = $config['port']; 
			$this->phpMailer->Username  = $this->username;  
			$this->phpMailer->Password  = $this->password;   
		} else {
			$this->phpMailer->Host      = $this->host;
			$this->phpMailer->Username  = $this->username;  
			$this->phpMailer->Password  = $this->password;
		}
		$this->phpMailer->SMTPDebug = 2;
	}
}

?>