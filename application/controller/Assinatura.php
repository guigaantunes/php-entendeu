<?php 
	class Assinatura extends Signoweb {
		var $tabela = 'assinatura';	
		
/*
		public function assinaturaAtiva($id_cliente=false) {
    		$classFatura = new Fatura;
    		
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		if (!$this->temAssinatura($id_cliente)) {
        		return false;
    		}
    		
            $fatura = $classFatura->getFatura($id_cliente);
            if (!$fatura || !$fatura['pago']) return false;
            
            $now = new DateTime();
            $termino_assinatura = DateTime::createFromFormat('Y-m-d H:i:s', $fatura['data_termino_assinatura']);

            if ($now > $termino_assinatura)
                return false;
            
            return true;
		}
*/
        
        /** Verifica se o cliente possui uma assinatura ativa.
          * Para isso, é necessário ter efetuado pagamento referente à assinatura
          * do mês corrente.
          *  
          * @parameter  [$id_cliente] [optional] Id do cliente a ser verificado.
                        se nenhum parametro for passado, pega da sessão atual
          *
          * @return     boolean Se possui ou não assinatura ativa.
          */
        public function assinaturaAtiva($id_cliente=false) {
            $Pagseguro  = new PagSeguroRecorrencia;
            $classPlano = new Plano;
            $classCliente=new Cliente;
            
            if ($id_cliente == "709") {
	            echo "Pesquisando assinatura ativa => assinaturaAtiva().";
            }
            //cliente é buscado. Se não foi passado um id, pegará o cliente logado
            $id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		    if (!$id_cliente) return false;
    		
			$cliente = $classCliente->getById($id_cliente);
    		
/*
    		if ($cliente['ativacao_manual']) 
    		    return true;
*/
            // se a assinatura foi ativada manualmente, então possui assinatura ativa
            if ($this->assinaturaAtivaManualmente($id_cliente))
                return true;
                	
            if ($id_cliente == "709") {
	            echo "<br>Sem assinatura manual.";
            }	
            // pega a assinatura do cliente para ter acesso ao código da adesao no pagseguro
    			$assinatura = $this->getAssinatura($id_cliente);
    			if ($id_cliente == "709") {
	            echo "<br>Assinatura do cliente.";
	            echo "<pre>".print_r($assinatura, true);
            }
            if ( !$assinatura || trim($assinatura['pagseguro_adesao']) == '' ) return false;
            
            // integração com o pagseguro para verificar a adesão e os pagamentos
            try {
	            if ($id_cliente == "709") {
		            echo "<br>Cahamar integração para checagem no PAGSEGURO";
		        }
        		$pagamentos = $Pagseguro->consultarPagamentos($idAdesao=$assinatura['pagseguro_adesao']);
        		$adesao     = $Pagseguro->consultarAdesao($idAdesao=$assinatura['pagseguro_adesao']);
            } catch(Exception $e){
	            if ($id_cliente == 709) {
		            echo "<pre>ERRO PAGSEGURO:";
	print_r($e, true);
		            }
                return false;
            }


if ($id_cliente == 709) {
	echo "<pre>PAGAMENTOS:";
	print_r($pagamentos, true);
	echo "ADESAO:";
	print_r($adesao, true);
}

    		// se adesão não existe, ou não está ativa, ou pagamentos não foram efetuados
    		// então a assinatura não está ativa
    		if (!$adesao || ($adesao && $adesao->status != "ACTIVE") ) return false;
    		if (!$pagamentos || !$pagamentos->paymentOrders) return false;
    		
    		$plano      = $classPlano->getById($assinatura['id_plano']);
    		
    		// verifica a data de adesão do cliente (no pagseguro)
    		$data_adesao    = DateTime::createFromFormat(DateTime::W3C, $adesao->date);
    		$data_atual     = new DateTime();
    		
    		// pega todos os pagamentos (do pagseguro)
    		$ordensPagamento = simpleXmlToArray($pagamentos->paymentOrders);
    		
    		// verifica os pagamentos
    		// ao encontrar um em que o pagamento tenha sido feito, e ainda não venceu,
    		// retorna verdadeiro, indicando que a a ssinatura está ativa
    		//$teste = simpleXmlToArray($adesao);
    		//echo "[ ".$assinatura['pagseguro_adesao']." ] <pre>".print_r($ordensPagamento, true).print_r($teste, true)."</pre>";
    		foreach($ordensPagamento as $ordem) {
        		$data_vencimento = clone $data_adesao;
        		
         		/* $dataPagamentoAgendado      = DateTime::createFromFormat(DateTime::W3C, $ordem['schedulingDate']); */
        		$data_pagamento             = DateTime::createFromFormat(DateTime::W3C, $ordem['lastEventDate']);
        		$mesesAssinatura            = $plano['meses'];

        		$data_vencimento->add( new DateInterval('P'.$mesesAssinatura.'M') );
        		# MUDEI O STATUS=2 PARA STATUS=5, DOCUMENTACAO INFORMA QUE É PAGA
        		if ( new DateTime() > $data_pagamento && new DateTime() < $data_vencimento && $ordem['status'] == 5 ) {
            		return true;
        		} 
    		}
    		
    		
    		//if ($adesao->status == "ACTIVE" && 
    		
    		// caso não tenha sido verificado um pagamento válido
    		// então a assinatura não está ativa
    		return false;
        }
        
         
        /** Verifica se o cliente possui uma assinatura ativa.
          * Para isso, é necessário ter efetuado pagamento referente à assinatura
          * do mês corrente.
          *  
          * @parameter  [$id_cliente] [optional] Id do cliente a ser verificado.
                        se nenhum parametro for passado, pega da sessão atual
          *
          * @return     boolean Se possui ou não assinatura ativa.
          */
        public function assinaturaAtivaManualmente($id_cliente=false) {
            $classCliente = new Cliente;
            
            $id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		$cliente = $classCliente->getById($id_cliente);
    		
    		if ($cliente['ativacao_manual']) 
    		    return true;
            return false;
        }
        
        /** Verifica se o cliente, que foi ativado manualmente, possui acesso ao vip.
          * A verificação do vip é feita através de uma flag.
          *  
          * @parameter  [$id_cliente] [optional] Id do cliente a ser verificado.
          *             se nenhum parametro for passado, pega da sessão atual
          *
          * @return     boolean Se possui ou não assinatura ativa.
          */
        public function acessoVipManualmente($id_cliente=false) {
            $classCliente = new Cliente;
    		
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		$cliente = $classCliente->getById($id_cliente);
    		
    		if (!$cliente)
    		    return false;
    		
    		
    		return !!$cliente['acesso_vip_manual'];
        }
		
		/**
          * Verifica se um cliente possui um registro de assinatua.
          * Um cliente possui assinatura se têm uma assinatura registrada (mesmo que em atraso),
          * ou se foi feita uma ativação manual.
          *
          * @param $id_cliente [int][optional] Id do cliente a ser verificado.
          *         se nenhum parametro for passado, pega da sessão atual 
          *
          * @return boolean
          */
		public function temAssinatura($id_cliente=false) {
    		$classCliente = new Cliente;
    		
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    
    		$cliente = $classCliente->getById($id_cliente);
            
/*
    		if ($cliente['ativacao_manual']) 
    		    return true;
*/

            if ($this->assinaturaAtivaManualmente($id_cliente))
                return true;
    		
    		
    		$sql = "SELECT * FROM {$this->tabela} WHERE status = 1 AND id_cliente = {$id_cliente}";
    		$retorno = $this->run($sql, array());
    		$retorno = end($retorno);
    		
    		return !!$retorno;
		}
		
		/**
    	  * Verifica se um cliente tem acesso ao conteúdo básico.
    	  * Se ele tem qualquer assinatura ativa (tanto manual quanto pagseguro),
    	  * ele possui acesso à pelo menos o conteúdo básico.
    	  *
    	  * @param $id_cliente [int][optional] Id do cliente a ser verificado.
          *         se nenhum parametro for passado, pega da sessão atual 
          *
          * @return boolean
		  */
		public function temAcessoBasico($id_cliente=false) {
    		$classCliente = new Cliente;
    		
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;


            if ($this->assinaturaAtiva($id_cliente))
                return true;
            
            
            return false;    
		}
		
		/**
    	  * Verifica se um cliente tem acesso ao conteúdo VIP.
    	  * O acesso ao VIP é permitido SE: ele tem assinatura ativa manualmente e possui flag de conteúdo VIP.
    	  * OU se o cliente possui uma assinatura VIP no pagseguro.
    	  *
    	  * @param $id_cliente [int][optional] Id do cliente a ser verificado.
          *         se nenhum parametro for passado, pega da sessão atual 
          *
          * @return boolean
		  */
		public function temAcessoVip($id_cliente=false) {
    		$classCliente = new Cliente;
    		
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		if ($this->assinaturaAtivaManualmente($id_cliente) && $this->acessoVipManualmente($id_cliente))
    		    return true;
    		    
    		    
            $assinatura = $this->getAssinatura($id_cliente);
            
            if (!$assinatura)
                return false;
                
            if ($this->assinaturaAtiva($id_cliente) && $assinatura['vip'])
                return true;
                
            return false;
		}
		
		
		public function getAssinatura($id_cliente=false) {
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		$sql = "SELECT * FROM {$this->tabela} WHERE status = 1 AND id_cliente = {$id_cliente} ORDER BY id ASC";
    		$retorno = $this->run($sql, array());
    		$retorno = end($retorno);
    		
    		return $retorno;
		}
		
		public function removeAssinaturas($id_cliente=false) {
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		$sql = "UPDATE {$this->tabela} SET status = 0 WHERE status = 1 AND id_cliente = {$id_cliente} ORDER BY id ASC";
    		return $this->run($sql, array(), $crud='d');
    		
		}
	}
?>