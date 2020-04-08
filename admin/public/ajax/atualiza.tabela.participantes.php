<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';

includeClasses('Resposta');

$classResposta      = new Resposta;
$classParticipante  = new Participante;

Resposta::$autoprint = false;

$ultimosParticipante = $classParticipante->listarUltimosCadastros(20);
echo data($ultimosParticipante);