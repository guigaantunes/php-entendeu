<?php
    
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";

 
$classResposta  = new Resposta;
$class          = new Configuracao;


if ($_POST) {
    $nome       = trim($_POST['nome']);
    $email      = trim($_POST['email']);
    $telefone   = trim($_POST['telefone']);
    $mensagem   = trim($_POST['msg']);
    
    $emailContato = $class->getById(1)['email_contato'];

    if( strlen($nome) == 0 || strlen($email) == 0 || strlen($mensagem) == 0 ) {
        $classResposta->insert('Erro ao enviar dados.', Resposta::ERROR);
		$classResposta->insert('Preencha os campos corretamente.', Resposta::ERROR);
		$classResposta->setStatus(false);
		die();
    }
    
    $to         = $emailContato;
    $headers    = mailHeader($email);
    $subject    = SITE_TITLE." | Contato";
    $message    = $mensagem . "<br><br>{$nome}<br>Telefone: {$telefone}";
    
    $sent = mail($to, $subject, $message, $headers);
    
//     var_dump($to, $headers, $subject, $message);
    
    if (!$sent) {
        $classResposta->insert('Erro ao enviar e-mail.', Resposta::ERROR);
		$classResposta->setStatus(false);
		die();
    }
    
    $classResposta->insert('E-mail enviado com sucesso.', Resposta::SUCCESS);
    
}