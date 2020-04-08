<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';

includeClasses('Resposta');

$classResposta  = new Resposta;
$classLance     = new Lance;

Resposta::$autoprint = false;

$lances = $classLance->listarUltimosLances(20);
echo data($lances);