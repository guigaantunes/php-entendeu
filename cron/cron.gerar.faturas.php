<?php
    
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
require_once(PATH_ABSOLUTO."classes/func.gerais.php");
require_once(PATH_ABSOLUTO."classes/func.banco.php");

$classCliente       = new Cliente;
$classAssinatura    = new Assinatura;
$classFatura        = new Fatura;
$classPlano         = new Plano;

$clientes = $classCliente->listAll();

$dias_vencimento = DIAS_VENCIMENTO_CRON;

foreach($clientes as $i => $cliente) {
    $fatura = $classFatura->getFatura($cliente['id']);
    
    if (!$fatura) continue;
    
    $dataAtual      = new DateTime();
    $dataVencimento = DateTime::createFromFormat('Y-m-d h:i:s', $fatura['data_vencimento']);
    
    $now = new DateTime();
    $termino_assinatura = DateTime::createFromFormat('Y-m-d H:i:s', $fatura['data_termino_assinatura']);

    if ($fatura['pago'] && $now > $termino_assinatura) {
        //gerar nova
        $novaFatura['id_cliente']       = $fatura['id_cliente'];
        $novaFatura['id_assinatura']    = $fatura['id_assinatura'];
        $novaFatura['valor']            = $fatura['valor'];
        $novaFatura['data_vencimento']  = date('Y-m-d H:i:s', strtotime("+$dias_vencimento day") );

        $success = $classFatura->insert($novaFatura);
        
    } else if (!$fatura['pago'] && $dataAtual > $dataVencimento) {
        $assinatura = $classAssinatura->getAssinatura($cliente['id']);
        if ($classAssinatura->assinaturaAtivaManualmente($cliente['id'])) {
          return true;
        }
        $classAssinatura->update($assinatura['id'], array('status'=> 2));
        $classFatura->update( $fatura['id'], array('status' => 0) );
    }
    
    
}