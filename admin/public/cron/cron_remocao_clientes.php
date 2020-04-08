<?php

/**
  *  Usuario ativo na rede
  *  
  *  - Checar se o usuario está atrasado a mais de X dias e removelo da rede se necessário
  */

require_once $_SERVER['DOCUMENT_ROOT']."/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/classes/func.gerais.php";

require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Signoweb.php";

require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Cliente.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Assinatura.php";


$Cliente = new Cliente;
$Assinatura = new Assinatura;

/*
    DIAS DE TOLERÂNCIA APÓS DATA DE VENCIMENTO DA ÚLTIMA ASSINATURA
*/
define('DIAS_APOS_VENCIMENTO', 10);
$CLIENTES_REMOVIDOS = 0;
    

/*
    Lista todos os clientes com status = 1
*/
$clientes = $Cliente->getBy(
    $dados      = array('status' => 1),
    $campos     = array('*'),
    $inner      = false,
    $left       = false,
    $groupBy    = false,
    $having     = false,
    $orderBy    = "id ASC"
);

/* Para cada cliente ativo */
foreach($clientes as $i => $cliente) {
    $id_formatado = str_pad($cliente['id'], 4, '0', STR_PAD_LEFT);
    
    /*
        Pega a última assinatura do cliente
    */
    $ultimaAssinatura = end($Assinatura->getBy(
        $dados = array(
            'id_cliente'=> $cliente['id'],
            'status'    => 1
        ),
        $campos = array(
            '*'
        ),
        $inner = false,
        $left = false,
        $groupBy = false,
        $having = false,
        $orderBy = "id ASC"
    ));
    
    /*
        Se cliente não possui assinatura alguma,
        está no plano gratuito. Então não será removidos
    */
    if (!$ultimaAssinatura) {
        echo "[CLIENTE $id_formatado]: não possui assinatura -> OK<br>";   
        continue;
    }
    
    if ($ultimaAssinatura['pago'] == 1) {
        echo "[CLIENTE $id_formatado]: já pagou assinatura -> OK<br>";
        continue;
    }
    
    /*
        Cria objetos DateTime :
        data de vencimento, data máxima de tolerancia
    */
    $data_vencimento = DateTime::CreateFromFormat('Y-m-d H:i:s', $ultimaAssinatura['data_vencimento']);
    
    $data_atraso = clone $data_vencimento;
    $data_atraso = $data_atraso->add(new DateInterval("P".DIAS_APOS_VENCIMENTO."D"));
    
    /*
        Se a data atual for maior que a data limite, 
        desativar cliente
    */
    if ((new DateTime) > $data_atraso) {
        echo "[CLIENTE $id_formatado]: data de tolerância passou -> REMOVER<br>";
        
        $Cliente->update($cliente['id'], array(
            'status' => 0
        ));
        
        ++$CLIENTES_REMOVIDOS;
    
    } else {
        echo "[CLIENTE $id_formatado]: OK<br>";
    }
    
}
    

echo "<br>$CLIENTES_REMOVIDOS CLIENTES FORAM REMOVIDOS";