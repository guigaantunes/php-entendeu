<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	//necessitaLogin();
	
	$class          = new Fatura;
	$classCliente   = new Cliente;
	$classAssinatura= new Assinatura;
	$classPlano     = new Plano;
	
	$modulo = "historicopagamento";
		
	if($_GET){
    	
    	$id = $_GET['id'];
		
		$registros = $class->getBy(
		    $dados  = array(
			    'fatura.id_cliente' => $id,
			    'fatura.status'     => 1
            ),
            $campos = array(
    			'fatura.*',
    			'fatura.id as DT_RowId',
    			'cliente.nome as nome',
    			'CONCAT("R$", FORMAT(assinatura.valor/100,2)) as valor',
    			'plano.titulo as plano',
    			'DATE_FORMAT(fatura.data_vencimento, "%d/%m/%Y") as data_vencimento',
    			'DATE_FORMAT(fatura.data_pagamento, "%d/%m/%Y") as data_pagamento'
            ),
            $inner  = array(
                'cliente' => array(
                    'fatura.id_cliente' => 'cliente.id'
                ),
                'assinatura' => array(
                    'assinatura.id' => 'fatura.id_assinatura'
                ),
                'plano' => array(
                    'assinatura.id_plano' => 'plano.id'
                )
            ),
            $left   = false,
            $groupBy= false,
            $having = false,
            $orderBy= 'fatura.id DESC'
		);

		
		echo data($registros);
	}
	
	if($_POST) {
		
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
		
		switch ($acao) {
    		case 'baixa':
    		    
    		    $fatura = $dados['id'];
    		    $success = $class->update($fatura, array(
        		    'pago'              => 1, 
        		    'data_pagamento'    => date('Y-m-d H:i:s'), 
        		    'observacoes'       => 'BAIXA MANUAL')
    		    );
    		    
    		    if (!$success) {
        		    $Resposta->insert('Erro ao dar baixa em fatura.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
    		    }
    		    
    		    $Resposta->insert('Fatura alterada com sucesso.', Resposta::SUCCESS);
    		    
    		    break;
		}
				
	}
	
?>