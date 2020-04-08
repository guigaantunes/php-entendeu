<?php	
	
	if (!$retorno_token OR !$retorno_email_pagseguro)
		die();
	
	$Pedidos = new Pedidos(); 

	class createLog{
	    private $name = 'log.txt';
	    private $type = 'ab';
	    public $log;
	    
      function __construct($path = '') {
	        $path = empty($path) ? $_SERVER["DOCUMENT_ROOT"] : $path;
	        $f = fopen ($path.$this -> name, $this -> type);
	        fwrite($f, $this -> log . "\n\n");
	        fclose($f);
      }
    
	    public function setLog($log){
	        $this -> log .= $log;
	    }
	    
	    public function createlog($path = '') {
		    $path = empty($path) ? $_SERVER["DOCUMENT_ROOT"] : $path;
	        $f = fopen ($path.$this -> name, $this -> type);
	        fwrite($f, $this -> log . "\n\n");
	        fclose($f);        
	    }
	}
	/* LOG */
	if($_REQUEST){    
	    $log = new createLog();
	    $log -> setLog("RECEBEU REQUEST @ " . date("d/m/Y H:i:s") . "\n");
	    $log -> setLog("<pre>" . var_export($_REQUEST, true) . "</pre>\n<--------------->\n");
	    $log -> createlog($_SERVER["DOCUMENT_ROOT"]);
	}


	function consultaTransacao($retorno_token, $retorno_email_pagseguro) {
		$curl = curl_init();
		$url = PAG_NOTIFICATION.$_REQUEST["notificationCode"]."?email=".$retorno_email_pagseguro."&token=".$retorno_token;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$transaction= curl_exec($curl);
		curl_close($curl);
		$file = fopen('log.txt', 'a');
		fwrite($file, $transaction);
		fclose($file);
		if($transaction == 'Unauthorized'){
			mail(EMAIL_DEBUG, "Erro PagSeguro", "Erro no tratamento de retorno:".$retorno_email_pagseguro);
		    exit;
		}
		$transaction = simplexml_load_string($transaction);
		return $transaction;
	}

	function MoedaBR($valor) {
		$valor = str_replace('.','',$valor);
		$valor = str_replace(',','.',$valor);
		return $valor;
	}

	function ConverterData($data) {
		$data = explode(' ', $data);
		$hora = $data[1]; $data = $data[0];
		$data = explode('/', $data);
		$data = $data[2].'-'.$data[1].'-'.$data[0].' ';		
		return $data.$hora;
	}

	$xml = consultaTransacao($retorno_token, $retorno_email_pagseguro);
		
	$log = new createLog();
    $log -> setLog("VERIFICANDO @ " . date("d/m/Y H:i:s") . "\n");
    $log -> setLog("<pre>" . var_export($xml, true) . "</pre>\n<--------------->\n");
    $log -> createlog($_SERVER["DOCUMENT_ROOT"]);
    
	// Recebendo Dados
	$Referencia = $xml->reference;
	$StatusPedido = $xml->status;

	# ABAIXO O RETORNO DE STATUS QUE O PAGSEGURO ENVIA 
	/*
	Status da transação.

	Informa o código representando o status da transação, permitindo que você decida se deve liberar ou não os produtos ou serviços adquiridos. Os valores possíveis estão descritos no diagrama de status de transações e são apresentados juntamente com seus respectivos códigos na tabela abaixo.
	
	Código	Significado
	1	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
	2	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
	3	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
	4	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
	5	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
	6	Devolvida: o valor da transação foi devolvido para o comprador.
	7	Cancelada: a transação foi cancelada sem ter sido finalizada.
	8	Chargeback debitado: o valor da transação foi devolvido para o comprador.
	9	Em contestação: o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
	Outros status menos relevantes foram omitidos. Em resumo, você deve considerar transações nos status de Paga para liberação de produtos ou serviços.
	
	Presença: Obrigatória.
	Tipo: Número.
	Formato: Inteiro.	
	*/
	# PAGAMENTO DE CLIQUES
	
	
	# AJUSTE PARA NÃO MUDAR STATUS VINDO DO PAGSEGURO
	var_dump($StatusPedido);
	switch ($StatusPedido) {
		case 1:
		case 2:
			// Nada
			break;
		case 3:
		case 4:
			//código de pagamento de fatura
			$parcela = $Pedidos->getParcelaById($Referencia);
			
			//atualiza valor da parcela paga
			$Pedidos->set($dadosParcela);
			
			var_dump($parcela);
			
			$log = new createLog();
		    $log -> setLog("PROCESSOU ATUALIZACAO REQUEST @ " . date("d/m/Y H:i:s"). " Status: " . $StatusPedido);
		    $log -> createlog($_SERVER["DOCUMENT_ROOT"]);
			break;
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
			//atualiza valor da parcela paga
			$Pedidos->set(array('id' => $Referencia, 'valor_pago' => 0, 'data_pagamento' => date('Y-m-d')));
			var_dump($Referencia, $StatusPedido);
			$log = new createLog();
		    $log -> setLog("PROCESSOU ATUALIZACAO REQUEST @ " . date("d/m/Y H:i:s"). " Status: " . $StatusPedido);
		    $log -> createlog($_SERVER["DOCUMENT_ROOT"]);
			break;
		default:
			$log = new createLog();
		    $log -> setLog("NAO PROCESSOU ATUALIZACAO REQUEST @ " . date("d/m/Y H:i:s"). " Status: " . $StatusPedido);
		    $log -> createlog($_SERVER["DOCUMENT_ROOT"]);
			break;
	}
	
// 	mail(EMAIL_DEBUG, 'Multipla Pagseguro '.__LINE__, print_r(array('Referência', $Referencia, 'Log', $log, 'XML', $xml, 'Request', $_REQUEST, 'ID', $Fatura->id, 'Fatura', $fatura), true));
?>
