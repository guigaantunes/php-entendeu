<?php

/**
  *  Convertes Pontos => R$
  *  
  *  - Pegar em ordem do Menor => Maior (ID).
  *  - Checar se o mesmo está qualificado conforme seu plano (usuario indicados diretos, compra minima, pagamento de plano, etc).
  *  - Estando qualificado lancar o valor em R$ como entrada no estrato conforme a configuração de conversação definida no plano.
  */

require_once $_SERVER['DOCUMENT_ROOT']."/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/classes/func.gerais.php";

require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Signoweb.php";

require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Cliente.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/ClientePlano.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Plano.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/ExtratoPontos.php";


$Plano = new Plano;
$Cliente = new Cliente;
$ClientePlano = new ClientePlano;
$ExtratoPontos = new ExtratoPontos;


/* 
    Lista todos os clientes com status = 1.
    
    Rotina irá rodar após cron de remoção de usuários, portanto nenhum
    cliente aqui listado está com assinatura atrasada
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

$TOTAL_PONTOS_CONVERTIDOS = 0;
$TOTAL_VALOR_CONVERTIDO = 0;

/* Para cada cliente ativo */
foreach($clientes as $i => $cliente) {
    $id_formatado = str_pad($cliente['id'], 4, '0', STR_PAD_LEFT);
    
    /*
        Pegar plano do cliente para verificação de
        valores de conversão e conversão máxima diária
    */
    $plano = $Plano->getById($ClientePlano->getPlano($cliente['id']));
    /* Conversão máxima diária (em centavos) */
    $ganho_maximo_diario = $plano['ganho_maximo_diario'];
    /* 1 ponto = X centavos */
    $valor_ponto = $plano['valor_ponto'];
    
    /* Verificar entradas do dia de hoje no extrato */
    $extrato_entradas_hoje = end($ExtratoPontos->getBy(
        $dados = array(
            'status'                => 1,
            'id_cliente'            => $cliente['id'],
            'tipo'                  => "entrada",
            'YEAR(data_cadastro)'   => date('Y'),
            'MONTH(data_cadastro)'  => date('m'),
            'DAY(data_cadastro)'    => date('d')
            
        ),
        $campos = array(
            'IFNULL(SUM(valor), 0) as valor_convertido'
        ),
        $inner      = false,
        $left       = false,
        $groupBy    = false,
        $having     = false,
        $orderBy    = false
    ));
    
    /* Valor já convertido hoje (em centavos) */
    $valor_convertido_hoje = (int)$extrato_entradas_hoje['valor_convertido'];
    /* Quantidade de pontos disponíveis para conversão */
    $pontos = $ExtratoPontos->getPontos($cliente['id']);
    /* Limitar o valor restante a ser convertidos hoje */
    $valor_restante = $ganho_maximo_diario - $valor_convertido_hoje;
    /* Pontos que ainda pode converter hj */
    $pontos_converter = floor($valor_restante/$valor_ponto);
    /*
        Mínimo entre pontos que possui e 
        restante de pontos que ainda pode converter hj
    */
    $pontos_converter = min($pontos_converter, $pontos);
    
    /* Verificar se o cliente está qualificado */
    if (!$Cliente->clienteQualificado($cliente['id'], $DEBUG = FALSE)) {
        echo "[CLIENTE $id_formatado]: Não está qualificado -> NÃO CONVERTER PONTOS<br>";
        continue;
    }

    /* Verificar se o cliente possui pontos disponíveis para conversão */
    if ($pontos_converter <= 1) {
        echo "[CLIENTE $id_formatado]: Não possui pontos disponíveis para conversão-> NÃO CONVERTER PONTOS<br>";
        continue;
    }
    
    /* Verificar se o cliente já converteu o máximo diário */
    if ($valor_convertido_hoje >= $ganho_maximo_diario) {
        echo "[CLIENTE $id_formatado]: Já converteu o valor máximo diário do plano -> NÃO CONVERTER PONTOS<br>";
        continue;
    }
    
    /* valor a ser convertido (em centavos) */
    $valor_convertido = $pontos_converter * $valor_ponto;
    

    /*
        Registrar um extrato com o valor convertido,
        quantidade de pontos convertidos
        na data atual
    */
    $success = $ExtratoPontos->insert(array(
        'id_cliente'        => $cliente['id'],
        'tipo'              => 'entrada',
        'carteira'          => 'backoffice',
        'pontos_convertidos'=> $pontos_converter,
        'valor'             => $valor_convertido,
        'instrucao'         => 'Conversão de pontos'
    ));
    
    if (is_numeric($success)) {
        $TOTAL_PONTOS_CONVERTIDOS += $pontos_converter;
        $TOTAL_VALOR_CONVERTIDO += $valor_convertido;
        
        echo "[CLIENTE $id_formatado]: CONVERTEU $pontos_converter PONTOS, GERANDO $valor_convertido centavos! -> OK<br>";
    } else {
        echo "[CLIENTE $id_formatado]: ERRO AO INSERIR EXTRATO";
    }
    
    
}

echo "<br>FORAM CONVERTIDOS $TOTAL_PONTOS_CONVERTIDOS PONTOS, GERANDO UM TOTAL DE R$".$TOTAL_VALOR_CONVERTIDO/100;
