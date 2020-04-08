<?php
	// Recorrência
	require_once 'Pagseguro.php';
	class PagSeguroRecorrencia extends PagSeguro {
		
		private $_PERIOD_LIST = array(
			'7'		=> 'WEEKLY',
			'30'	=> 'MONTHLY',
			'60'	=> 'BIMONTHLY',
			'90'	=> 'TRIMONTHLY',
			'180'	=> 'SEMIANNUALLY',
			'365'	=> 'YEARLY'
		);
		
		/* CRIAÇÃO DE PLANO */
		/**
		* @param string $valor (2000.01 > valor > 0.99)
		* @param string $nomePlano Nome do plano
		* @param numeric $period days period (key to $this->_PERIOD_LIST)
		*
		* @return object plano
		*/
		public function gerarPlano($valor, $nomePlano, $period) {
			if (empty($this->_PERIOD_LIST[$period])) {
				throw new PagseguroException('Período de recorrência inválido', 403);
			}
			
			$jsonData = array(
				'preApproval' 	=> array(
					'name'					=> $nomePlano,
					'amountPerPayment'		=> $valor,
					'charge'				=> "AUTO",
/*
					'maxAmountPerPeriod'	=> $valor,
					'charge'				=> "MANUAL",
*/
					//'trialPeriodDuration'	=> 1,
					'period'				=> $this->_PERIOD_LIST[$period],
					'cancelURL'				=> (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER["HTTP_HOST"]
				),
				'receiver'		=> array(
					'email'			=> $this->getEmail()
				)
			);
			
			$plano = $this->request('/pre-approvals/request', 'POST', $jsonData, 'JSON');
			return $plano;
		}
		
		/* CRIAR ADESÃO */
		/**
		* CRIAR ADESÃO
		*
		* EXEMPLO:
		* 
		* $sender = array(
		* 	'sender_phone'			=> '41997571749',
		* 	'sender_street'			=> 'Rua Tchanãnã',
		* 	'sender_number'			=> '41',
		* 	'sender_complement'		=> '',
		* 	'sender_district'		=> 'Xaxim',
		* 	'sender_city'			=> 'Curitiba',
		* 	'sender_state'			=> 'PR',
		* 	'sender_email'			=> 'angel@signoweb.com.br',
		* 	'sender_cpf'			=> '71053852193',
		* 	'sender_name'			=> 'Angel Pereira',
		*	'sender_postalCode'		=> '81280050'
		* );
		* 
		* $holder = array(
		* 	'card_name'			=> 'Angel M S Pereira',
		* 	'card_cpf'			=> '71053852193',
		* 	'card_phone'	 	=> '41997571749',
		* 	'card_birthdate'	=> '30/05/1994'
		* );
		*
		* @param alphanumeric idPlano 
		* @param numeric idPedido
		* @param alphanumeric cardToken
		* @param array sender dados do cliente
		* @param array holder dados do dono do cartão
		* 
		* @return object adesao
		*/
		public function criarAdesao($idPlano, $referencia, $cardToken, $sender, $holder) {
			if (empty($sender)) {
				throw new PagSeguroException( 'Usuário inválido' , 400);
			}
			
			if (empty($holder)) {
				throw new PagSeguroException( 'Dono de cartão inválido', 400 );
			}
			
			//$senderPhone = self::soNumero($sender['sender_phone']);
			//$holderPhone = self::soNumero($holder['card_phone']);
			$postFields = array(
				'plan'		=> str_replace('-', '', $idPlano) ,
				'reference' => $referencia,
				'sender'	=> array(
					'name'			=> $sender['sender_name'],
					'email'			=> ($this->_SANDBOX ? self::SANDBOX_SENDER_EMAIL : $sender['sender_email']),
					'ip'			=> $_SERVER['REMOTE_ADDR'],
					'phone'			=> array(
						'areaCode'		=> $sender['sender_areaCode'],//substr($senderPhone, 0, 2),
						'number'		=> $sender['sender_phone']//substr($senderPhone, 2)
					),
					'address'		=> array(
						"street"		=> $sender['sender_street'],
						"number"		=> $sender['sender_number'],
						"complement"	=> $sender['sender_complement'],
						"district"		=> $sender['sender_district'],
						"city"			=> $sender['sender_city'],
						"state"			=> $sender['sender_state'],
						"country"		=> "BRA",
						"postalCode"	=> $sender['sender_postalCode']
					),
					"documents"		=> array(
						array(
							"type"		=> "CPF",
							"value"		=> self::soNumero($sender['sender_cpf'])
						)
					)
				),
				"paymentMethod"	=> array(
					"type"			=> "CREDITCARD",
					"creditCard"	=> array(
						"token"			=> $cardToken,
						"holder"		=> array(
							"name"			=> $holder['card_name'],
							"birthDate" 	=> $holder['card_birthdate'],
							"documents" 	=> array(
								array(
									"type"		=> "CPF",
									"value"		=> self::soNumero($holder['card_cpf'])
								)
							),
							'phone'			=> array(
								'areaCode'		=> $holder['card_areaCode'],//substr($holderPhone, 0, 2),
								'number'		=> $holder['card_phone'],//substr($holderPhone, 2)
							)
						)
					)
				)
			);
			//echo "<pre>".print_r($postFields, true)."</pre>";
			$adesao = $this->request('/pre-approvals', 'POST', $postFields, 'JSON');
			
			//var_dump($adesao); die();
			return $adesao;
		}
		
		/* CANCELAR ADESÃO */
		/**
		* Cancela a adesão, o plano só pode ser cancelado pelo site do pagseguro
		*
		* @param alphanumeric idAdesao 
		*
		* @return ????
		*/
		public function cancelarAdesao($idAdesao) {
			$content = $this->request('/pre-approvals/'.$idAdesao.'/cancel/', 'PUT', array(), 'JSON');
			return $content;
		}
		
		/* CONSULTAR PAGAMENTOS DO PLANO */
		/**
		* Consulta todas as ordens de pagamento de um plano
		*
		* @param alphanumeric idAdesao 
		* @param integer page 
		*
		* @return array https://dev.pagseguro.uol.com.br/referencia-da-api/api-de-pagamentos-pagseguro#!/ws_pagseguro_uol_com_br/pre_approvals_list_orders_xml
		*/
		public function consultarPagamentos($idAdesao, $page = 1) {
			$content = $this->request('/pre-approvals/'.$idAdesao.'/payment-orders', 'GET', array('maxPageResults' => 1000, 'page' => $page), 'JSON');

			if ($content->currentPage !== $content->totalPages)
				return $this->consultarPagamentos($idAdesao, $content->totalPages);
			
			return $content;
		}
		
		/* CONSULTAR Dados da adesão */
		/**
		* Permite consultar os dados de uma recorrencia.
		*
		* @param alphanumeric idAdesao 
		* @param integer page 
		*
		* @return array https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/pre-approval-code
		*/
		public function consultarAdesao($idAdesao, $page = 1) {
			$content = $this->request('/pre-approvals/'.$idAdesao, 'GET', array('maxPageResults' => 1000, 'page' => $page), 'JSON');
			
			if ($content->currentPage !== $content->totalPages)
				return $this->consultarPagamentos($idAdesao, $content->totalPages);
			
			return $content;
		}
		
		/* CUPOM DE DESCONTO */
		/**
		* Cria um desconto para a próxima parcela
		*
		* @param alphanumeric idAdesao 
		* @param float valor 
		*
		* @return array https://dev.pagseguro.uol.com.br/referencia-da-api/api-de-pagamentos-pagseguro#!/ws_pagseguro_uol_com_br/pre_approvals_list_orders_xml
		*/
		public function desconto($idAdesao, $valor) {
			$content = $this->request('/pre-approvals/'.$idAdesao.'/discount', 'PUT', array('type' => 'DISCOUNT_AMOUNT', 'value' => number_format($valor, 2, '.', '')), 'JSON');
			return $content;
		}
		
		/* PAGAMENTO DE PARCELA */
		/**
		* Paga uma parcela da adesão
		*
		* Cuidado: Essa função precisa ser rodada exatamente na data em que foi agendada, do contrário ela não será cobrada
		*
		* @param alphanumeric idAdesao 
		* @param float valor 
		*
		* @return array https://dev.pagseguro.uol.com.br/referencia-da-api/api-de-pagamentos-pagseguro#!/ws_pagseguro_uol_com_br/pre_approvals_list_orders_xml
		*/
		public function pagamento($idAdesao, $idPlano, $idJogador, $ip, $valor) {
			$postFields = array(
				'preApprovalCode' => $idAdesao, //`id_adesao`
				'reference'	=> 'PLAN:' . $idPlano . ':' . $idJogador, //`id`,
				'senderIp' => $ip,
				'items' => array(
					"id" => $idPlano.date('dmy'),
					"description" => "Assinatura GamersXP " . date('m \d\e y'),
					"quantity" => 1,
					"amount" => number_format($valor, 2, '.', ''),
					"weight" => '1',
					"shippingCost" => '0.00'
				)
			);
			$content = $this->request('/pre-approvals/payment', 'PUT', $postFields, 'JSON');
			return $content;
		}
		
		
		/* CONSULTAR PAGAMENTOS DO PLANO */
		/**
		* Consulta todas as ordens de pagamento de um plano
		*
		* @param alphanumeric idAdesao 
		* @param float valor 
		*
		* @return array https://dev.pagseguro.uol.com.br/referencia-da-api/api-de-pagamentos-pagseguro#!/ws_pagseguro_uol_com_br/pre_approvals_list_orders_xml
		*/
		public function descontoAdesao($idAdesao, $valor) {
			$content = $this->request('/pre-approvals/'.$idAdesao.'/discount', 'PUT', array(
				'type' => 'DISCOUNT_AMOUNT',
				'value' => number_format($valor, 2, '.', '')
			), 'JSON');
			debug_log($content);
			return $content;
		}
	}
?>