<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
require_once(PATH_ABSOLUTO."classes/func.gerais.php");
require_once(PATH_ABSOLUTO."classes/func.banco.php");
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";

$classResposta  = new Resposta;

$class          = new Assinatura;
$classPlano     = new Plano;
//$classFatura    = new Fatura;

if ($_POST) {
	$dados = $_POST['dados'];
	$dados['id_cliente'] = $_SESSION['cliente']['id'];
	
	if (!isset($_SESSION['cliente']['id'])) {
    	$classResposta->insert('Deve estar logado para assinar um plano.', Resposta::ERROR);
    	$classResposta->setStatus(false);
        die();
	}
	
	if ( $class->temAssinatura() ) {
    	$classResposta->insert('Você já possui uma assinatura ativa.', Resposta::ERROR);
    	$classResposta->setStatus(false);
        die();
	}

	# TESTE DE CENÁRIO
    if ($_SESSION['cliente']['id'] == "760") {
	    $dados['id_plano'] = 2;
    }
    
	$plano = $classPlano->getById($dados['id_plano']);
	
	
	$add        = $plano['meses'];
	//$interval   = new DateInterval("P{$add}M");
	$termino    = new DateTime(); 
	$termino->add(new DateInterval("P{$add}M"));


	$dados['valor'] = ($dados['vip'] ? $plano['valor_vip']*$plano['meses'] : $plano['valor_basico']*$plano['meses'] );
	$dados['termos']= $plano['termos'];
	$dados['pagseguro_plano'] = ($dados['vip'] ? $plano['pagseguro_codigo_vip'] : $plano['pagseguro_codigo_basico']);
	
	
	
	//$dados['data_termino'] = $termino->format('Y-m-d H:i:s');
	
	$class->removeAssinaturas();
	$assinatura = $class->insert($dados);
	
	if ( !is_numeric($assinatura) ) {
    	$classResposta->insert('Erro ao gerar assinatura.', Resposta::ERROR);
    	$classResposta->setStatus(false);
        die();
	}
	
	$dados['data_termino_assinatura'] = $termino->format('Y-m-d H:i:s');
	
/*
	unset($dados['vip']);
	unset($dados['id_plano']);
	unset($dados['termos']);
	unset($dados['data_termino']);
	
	$interval   = new DateInterval("P1D");
	$vencimento = new DateTime("");
	$vencimento->add($interval);
	
	$dados['id_assinatura'] = $assinatura;
	$dados['data_vencimento'] = $vencimento->format('Y-m-d H:i:s');
	
    $fatura = $classFatura->insert($dados);
    
    if ( !is_numeric($fatura) ) {
        $classResposta->insert('Erro ao gerar fatura.', Resposta::ERROR);
    	$classResposta->setStatus(false);
        die();
    }
*/
    $classResposta->add('assinatura', $assinatura);
    $classResposta->insert('Plano escolhido com sucesso.', Resposta::SUCCESS);
    $classResposta->insert('Você será redirecionado para a tela de integração com o PagSeguro.', Resposta::SUCCESS);
	
}