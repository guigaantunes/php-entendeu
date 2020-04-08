<?php
    
    session_start();
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
    
     
    $classResposta  = new Resposta;
    $class          = new Cliente;
    
	unset($_SESSION['cliente']);