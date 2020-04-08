<?php
    
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";

 
$classResposta  = new Resposta;
$class          = new ClienteLeuMaterial;
$classMaterial  = new MaterialEstudo;


if ($_POST) {
    $dados = $_POST['dados'];
    
    $success = $class->alterarStatus($dados['id'], $dados['status']);
    
    if (!$success) {
        $classResposta->insert('Erro ao alterar status do conteúdo.', Resposta::ERROR);
        die();
    }
        
    $classResposta->insert('Status alterado com sucesso.', Resposta::SUCCESS);
    
}