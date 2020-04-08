<?php
    
    session_start();
	
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	require_once(PATH_ABSOLUTO."classes/func.gerais.php");
    require_once(PATH_ABSOLUTO."classes/func.banco.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/application/controller/GetInstallments.php');


    $classResposta  = new Resposta;
/*
	require_once $_SERVER['DOCUMENT_ROOT']."/classes/Pagseguro.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/classes/Pedido.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/classes/Email.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/classes/GetInstallments.php";
*/
	
	$Pag                = new PagSeguroRecorrencia; 
    $classPlano         = new Plano;
    $classFatura        = new Fatura;
    $classAssinatura    = new Assinatura;

	
	if ($_POST) {
		
        $id             = $_POST['id_assinatura'];
        $assinatura     = $classAssinatura->getById($id);
        
		$method         = $_POST['dados']['paymentMethod'];
		$dados1          = $_POST['dados'];
		$credito        = $_POST['credito'];
		
        $valor          = $assinatura['valor']/100;
        $installments   = $_POST['installments'];
        
		$dados1['itemId1']                   = $assinatura['id'];
		$dados1['itemDescription1']          = 'default';
		$dados1['itemAmount1']               = number_format($valor, 2, '.', '');
		$dados1['itemQuantity1']             = 1;
		
        	$dados1['sender_areaCode']           = str_replace(array( '(', ')' ),          '', $dados1['areaCode']);
		$dados1['sender_phone']              = str_replace(array( '(', ')', ' ', '-' ),'', $dados1['number']);
		$dados1['sender_cpf']                = str_replace(array('-','.' ),            '', $dados1['sender_CPF']);
		
		
		$credito['card_areaCode']           = str_replace(array( '(', ')' ),          '', $credito['card_areaCode']);
		$credito['card_phone']              = str_replace(array( '(', ')', ' ', '-' ),'', $credito['card_phone']);
		$credito['creditCardHolderAreaCode']= str_replace(array( '(', ')' ),          '', $credito['creditCardHolderAreaCode']);
		$credito['creditCardHolderPhone']   = str_replace(array( '(', ')', ' ', '-' ),'', $credito['creditCardHolderPhone'] );
		$credito['creditCardHolderCPF']     = str_replace(array('-','.' ),            '', $credito['creditCardHolderCPF']);
		$dados1['sender_state']    = strtoupper($credito['billingAddressState']);
		
        $valor = number_format($valor, 2, '.', '');  


		$xml = $Pag->criarAdesao($idPlano=$assinatura['pagseguro_plano'],
		                         $referencia=$id, 
		                         $cardToken=$credito['creditCardToken'], 
		                         $sender=$dados1, 
		                         $holder=$credito);
        

		if (!isset($xml->error)) {
    			$codigo_adesao = $xml->code;

            $updateAssinatura = $classAssinatura->update($id, array('pagseguro_adesao' => $codigo_adesao));
            
			$classResposta->insert('Adesão ao plano efetuada com sucesso!', Resposta::SUCCESS);
			die();
        	}
        	
        	$pagseguroerros=$xml->errors;
        	foreach($pagseguroerros as $numerror => $errors){
        	
        	$echoerrors= $numerror ;
        	
        	}
        	var_dump();
		$classResposta->insert($echoerrors,Resposta::ERROR);	
    }