<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
	require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";

 
$Resposta       = new Resposta;
$classMateria   = new Materia;
$classTopico    = new Topico;

//$Resposta::$autoprint = false;

if ($_GET) {
    $idMateria = $_GET['idMateria'];
    
    $topicos = $classTopico->getBy(
        $dados = array(
            'status' => 1,
            'id_materia' => $idMateria
        ),
        $campos = array(
            '*'
        )
    );
  
    $Resposta->add('topicos', $topicos);
}

