<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
	require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";

 
$Resposta      = new Resposta;
$classMateria  = new Materia;

//$Resposta::$autoprint = false;

if ($_GET) {
    $idDisciplina = $_GET['idDisciplina'];
    
    $materias = $classMateria->getBy(
        $dados = array(
            'status' => 1,
            'id_disciplina' => $idDisciplina
        ),
        $campos = array(
            '*'
        )
    );
  
    $Resposta->add('materias', $materias);
}

