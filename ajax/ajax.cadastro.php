<?php
    
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
require_once("lib/ApiMailchimp.php");
 
$classResposta  = new Resposta;
$class          = new Cliente;

//$Resposta::$autoprint = false;

/*
$email = $_POST['email'];
$senha = $_POST['senha'];
*/
if ($_POST) {
    
    $dados = $_POST['dados'];
    $senha = $dados['senha'];
    
    if(!validaEmail($dados['email'])){
      $classResposta->insert('Erro na tentativa de cadastro.', Resposta::ERROR);
      $classResposta->insert('O e-mail é invalido.', Resposta::ERROR);
      $classResposta->setStatus(false);
      die();
    }
  
    if (strlen(trim($dados['email'])) == 0) {
        $classResposta->insert('Erro na tentativa de cadastro.', Resposta::ERROR);
        $classResposta->insert('Um e-mail deve ser informado.', Resposta::ERROR);
        $classResposta->setStatus(false);
        die();
    }
    
    if (strlen(trim($dados['senha'])) == 0) {
        $classResposta->insert('Erro na tentativa de cadastro.', Resposta::ERROR);
        $classResposta->insert('Uma senha deve ser informada.', Resposta::ERROR);
        $classResposta->setStatus(false);
        die();
    }
    
    if ($dados['senha'] != $dados['csenha']) {
        $classResposta->insert('Erro na tentativa de cadastro.', Resposta::ERROR);
        $classResposta->insert('Senha não conferem.', Resposta::ERROR);
        $classResposta->setStatus(false);
        die();
    }
    
    $emailExiste = $class->getBy(
        array(
            'status'    => 1,
            'email'     => $dados['email']
        )
    );
    
    if ($emailExiste) {
        $classResposta->insert('Erro na tentativa de cadastro.', Resposta::ERROR);
        $classResposta->insert('E-mail já cadastrado.', Resposta::ERROR);
        $classResposta->setStatus(false);
        die();
    }
    
    unset($dados['csenha']);
    
    $dados['senha'] = md5($dados['senha']);
    
    $success = $class->insert($dados);
    
    if (!$success) {
        $classResposta->insert('Erro na tentativa de cadastro.', Resposta::ERROR);
        $classResposta->setStatus(false);
        die();
    }
    
    //logar
    
    $usuario = $class->login($dados['email'], $senha);
	
	if($usuario){
    	$_SESSION['cliente'] = array(
    		'id'        => $usuario['id'],
    		'nome'      => $usuario['nome'],
    		'email'     => $usuario['email'],
    		'telefone'  => $usuario['telefone']
    	);
	}

    
    $classResposta->insert('Cadastro efetuado com sucesso.', Resposta::SUCCESS);
    
}
$MailChimp = new MailChimp(MAILCHIMP_KEY);
$result = $MailChimp->call('lists/subscribe', array(
    'id' => MAILCHIMP_LIST_ID,
    'email' => array('email' => $dados['email']),
    'merge_vars' => array('FNAME' => $dados['nome'], 'PHONE' => $dados['telefone']),
    'double_optin' => MAILCHIMP_DOUBLE_OPTIN, //CONFIRMAÇÃO DE EMAIL
    'update_existing' => MAILCHIMP_UPDATE_EXISTING, //ATUALIZAR LEAD EXISTENTE
    'replace_interests' => false,
    'send_welcome' => false,
        ));
function validaEmail($email) {
$conta = "/^[a-zA-Z0-9\._-]+@";
$domino = "[a-zA-Z0-9\._-]+.[.]";
$extensao = "([a-zA-Z]{2,4})$/";
$pattern = $conta . $domino . $extensao;
if (preg_match($pattern, $email)) {
return true;
} else {
return false;
}

}

