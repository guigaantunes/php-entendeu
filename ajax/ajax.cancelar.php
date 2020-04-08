<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
require_once(PATH_ABSOLUTO."classes/func.gerais.php");
require_once(PATH_ABSOLUTO."classes/func.banco.php");
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";

$classResposta  = new Resposta;
$class          = new Assinatura;
$classFatura    = new Fatura;

if ($_GET) {
    $assinatura = $class->getAssinatura();
    
    $success = $class->update($assinatura['id'], array('status'=>2));
    //$success = true;
    if ($success) {
        $fatura = $classFatura->getBy(
            array(
                'status' => 1,
                'id_assinatura' => $assinatura['id']
            )
        );
        $fatura = end($fatura);

        $classFatura->update($fatura['id'], array('status'=>0));

        $classResposta->insert('Assinatura cancelada.', Resposta::SUCCESS);
        die();
    }

    $classResposta->insert('Erro ao cancelar assinatura.', Resposta::ERROR);

}