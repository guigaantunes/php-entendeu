<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
	require_once($_SERVER['DOCUMENT_ROOT']."/application/controller/StreamerAgenda.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/application/controller/Jogador.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/application/controller/JogadorPlano.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/application/controller/JogadorPlanoPagamento.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/application/controller/Streamer.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/classes/Pagseguro.php");
	
	$classAgenda = new StreamerAgenda;
	$classPagseguroNotificacao = new PagSeguroNotificacao(PAGSEGURO_SANDBOX);
	$classPagSeguroRecorrencia = new PagSeguroRecorrencia(PAGSEGURO_SANDBOX);
	
	if ($_REQUEST['notificationType'] == 'preApproval') {
		$xml = $classPagseguroNotificacao->consultaPreapproval(str_replace('-', '', $_REQUEST["notificationCode"]));
	} else {
		$xml = $classPagseguroNotificacao->consultaTransacao(str_replace('-', '', $_REQUEST["notificationCode"]));
	}
	
	// Recebendo Dados
	$Referencia = $xml->reference;
	$StatusPedido = $xml->status;
	
	if (!$Referencia) {
		$classPagseguroNotificacao->log('Nуo conseguiu processar request '.var_export($_REQUEST, true));
		die();
	}
	
	# ABAIXO O RETORNO DE STATUS QUE O PAGSEGURO ENVIA 
	/*
	Status da transaчуo.

	Informa o cѓdigo representando o status da transaчуo, permitindo que vocъ decida se deve liberar ou nуo os produtos ou serviчos adquiridos. Os valores possэveis estуo descritos no diagrama de status de transaчѕes e sуo apresentados juntamente com seus respectivos cѓdigos na tabela abaixo.
	
	Cѓdigo	Significado
	1	Aguardando pagamento: o comprador iniciou a transaчуo, mas atщ o momento o PagSeguro nуo recebeu nenhuma informaчуo sobre o pagamento.
	2	Em anсlise: o comprador optou por pagar com um cartуo de crщdito e o PagSeguro estс analisando o risco da transaчуo.
	3	Paga: a transaчуo foi paga pelo comprador e o PagSeguro jс recebeu uma confirmaчуo da instituiчуo financeira responsсvel pelo processamento.
	4	Disponэvel: a transaчуo foi paga e chegou ao final de seu prazo de liberaчуo sem ter sido retornada e sem que haja nenhuma disputa aberta.
	5	Em disputa: o comprador, dentro do prazo de liberaчуo da transaчуo, abriu uma disputa.
	6	Devolvida: o valor da transaчуo foi devolvido para o comprador.
	7	Cancelada: a transaчуo foi cancelada sem ter sido finalizada.
	8	Debitado: o valor da transaчуo foi devolvido para o comprador.
	9	Retenчуo temporсria: o comprador contestou o pagamento junto р operadora do cartуo de crщdito ou abriu uma demanda judicial ou administrativa (Procon).
	Outros status menos relevantes foram omitidos. Em resumo, vocъ deve considerar transaчѕes nos status de Paga para liberaчуo de produtos ou serviчos.
	
	Presenчa: Obrigatѓria.
	Tipo: Nњmero.
	Formato: Inteiro.
	*/
	# PAGAMENTO DE CLIQUES
	
	# AJUSTE PARA NУO MUDAR STATUS VINDO DO PAGSEGURO
	
	$statusTexto = array(
		'Indefinido',
		'Aguardando Pagamento',
		'Em Anсlise',
		'Pago',
		'Disponэvel',
		'Compra entrou em disputa',
		'Compra foi devolvida',
		'Compra foi cancelada',
		'O valor da transaчуo foi devolvido para o comprador',
		'Compra foi retida temporariamente'
	);
	
	/*
		$tipo
			HORA: Jogador reservou horсrio com streamer
			PLAN: Notificaчуo sobre criaчуo de um plano
	*/
	
	list($tipo, $idReferencia, $idJogador) = explode(':', $Referencia);			
	
	switch ($tipo) {
		case 'HORA' :
			if ($StatusPedido == 4)
				break;
				
			$classAgenda->id = $idReferencia;
			    
		    $dadosAgenda = $classAgenda->get();
		    
		    $classStreamer = new Streamer;
		    $classJogador = new Jogador;
		    
		    $classStreamer->id = $dadosAgenda['id_streamer'];
		    $classJogador->id = $idJogador;
		    
		    $dadosStreamer = $classStreamer->get();
		    $dadosJogador = $classJogador->get();
			
			if ($StatusPedido == 3) {
			    $classAgenda-> horarioReservado(
			    	$dadosJogador['email'], 
			    	$dadosJogador['nome'], 
			    	$dadosStreamer['email'], 
			    	$dadosStreamer['nick'], 
			    	$dadosAgenda['data_hora']
			    );
			    
			    $classPagseguroNotificacao->log("HORСRIO RESERVADO: $Referencia\n");
			} else {
				if (!$classAgenda->jogadorIsInscrito($idJogador))
					break;
					
				$classAgenda->removeJogador($idJogador);
			    $classAgenda-> horarioCancelado(
			    	$dadosJogador['email'], 
			    	$dadosJogador['nome'], 
			    	$dadosStreamer['email'], 
			    	$dadosStreamer['nick'],
			    	$dadosAgenda['data_hora'], 
			    	$statusTexto[(int)$StatusPedido]
			    );
				
			    $classPagseguroNotificacao->log("HORСRIO CANCELADO: $idReferencia\n");
			}
			break;
		case 'PLAN' :
			$classPlano = new JogadorPlano;
			$classPlano->id = $idReferencia;
			$dadosPlano = $classPlano->get();
			
			$classJogador = new Jogador;
			$classJogador->id = $idJogador;
			$dadosJogador = $classJogador->get();
			
			if ($StatusPedido == 3 OR $StatusPedido == 4 OR ($StatusPedido == 6 AND $xml->grossAmount == '1.50')) {
				$classPlano->consultarPagamentos($dadosPlano['id_adesao'], $idJogador, $xml->grossAmount);
				$classPlano->planoAssinado($dadosJogador['email'], $dadosJogador['nome'], $dadosPlano['tipo_plano']);
				
			    $classPagseguroNotificacao->log("ASSINATURA DE PLANO PAGA: $Referencia");
			} else if ($StatusPedido !== 'ACTIVE') {
				$listaPagamentos = $classPlano->getPagamentos($idJogador);
				
				if ($listaPagamentos[0]['id_jogador_plano_pagamento_status'] == 2) {
					$classPagamento = new JogadorPlanoPagamento;
					$classPagamento->id = $listaPagamentos[0]['id'];
					
					$pagamentoAtualizado = array('id_jogador_plano_pagamento_status' => 6, 'id_pagamento' => $listaPagamentos[0]['id_pagamento']);
					$classPagamento->set($pagamentoAtualizado);
						
					$classPlano->planoCancelado($dadosJogador['email'], $dadosJogador['nome'], $dadosPlano['tipo_plano'], 'Pagamento nуo foi processado pelo pagseguro');
				}
	
				$classPlano->delete();
				
				$classPagSeguroRecorrencia->cancelarAdesao($dadosPlano['id_adesao']);
				
			    $classPagseguroNotificacao->log("PLANO CANCELADO: $Referencia");	
			}
			break;
		default:
		    $classPagseguroNotificacao->log("ERRO!!!!!!!!!!!!!!!!!!!!!! TIPO DE NOTIFICУO NУO CONFIGURADO");
			break;
	}
	
	$classPagseguroNotificacao->log(var_export(array('Referъncia', $Referencia, 'XML', $xml, 'Request', $_REQUEST), true));
?>