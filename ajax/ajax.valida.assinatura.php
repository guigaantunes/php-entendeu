<?php
    
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";

 
$classResposta  = new Resposta;
$class          = new Cliente;
$classAssinatura= new Assinatura;

$logado             = isset($_SESSION['cliente']['id']);
$temAssinatura      = $classAssinatura->temAssinatura();
$assianturaAtiva    = $classAssinatura->assinaturaAtiva();

if (!$logado) {
    $classResposta->insert('Deve estar logado para ter acesso aos conteúdos.', Resposta::ERROR);
    $classResposta->setStatus(false);
    die();
}

if (!$temAssinatura || !$assianturaAtiva) {
    $classResposta->insert('Você não tem uma assinatura ativa.', Resposta::ERROR);
    $classResposta->setStatus(false);
    die();
}
