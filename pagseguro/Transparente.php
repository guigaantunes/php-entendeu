<?php
	// Transparente
	require_once 'Pagseguro.php';
	class PagSeguroTransparente extends PagSeguro {
		
		public function efetuarPagamentoCredito($cardToken, $description, $idReferece, PagSeguroItemList $arrayItens, $sender, $holder, $shipping, $billing, $amount) {
			$postFields = array(
				'mode'							=> 'default',
				'currency'						=> 'BRL',
				'receiverEmail'					=> $this->getEmail(),
				'method'						=> 'credit_card',
				'items'							=> $arrayItens,
				'sender'						=> $sender,
				'creditCard'					=> array(
					'token'							=> $cardToken,
					'holder'						=> $holder,
					'billingAddress'				=> $billing,
					'installment'					=> array(
						'quantity'						=> 1,
						'noInterestInstallmentQuantity' => 2,
						'value'							=> $amount
					)
				),
				'dynamicPaymentMethodMessage'	=> array(
					'creditCard'					=> $description
				),
				'reference'						=> $idReferece,
				'shipping'						=> $shipping
			);
			
			$compra = $this->request('/v2/transactions', 'POST', $postFields, 'XML', 'payment');
			return $compra;
		}
	}
	
	// "Mas essa classe é realmente importante?"
	// Sim!!
	class PagSeguroItem {
		var $id, $description, $amount, $quantity;
		
		public function __construct($id, $description, $amount, $quantity) {
			$this->id = $id;
			$this->description = $description;
			$this->amount = str_replace(',', '.', $amount);
			$this->quantity = $quantity;
		}
		
		public function asXML() {
			$xml = new SimpleXMLElement('<item/>');
			$arrayThis = $this->asArray();
			foreach($arrayThis as $key => $attr) {
				$xml->addChild($key, $attr);
			}
			return $xml->asXML();
		}
		
		public function asArray() {
			return (array)$this;
		}
	}
	
	class PagSeguroItemList {
		var $lista;
		
		public function __construct() {
			$lista = func_get_args();
			foreach ($lista as $key => $Item) {
				if ($Item instanceof PagSeguroItem) {
					$this->lista[] = $Item;
				} else {
					trigger_error('Campo '.$key.' ignorado por não ser instância de PagSeguroItem', E_WARNING);
				}
			}
		}
		
		public function asXML() {
			$lista = '';
			foreach ($this->lista as &$item) {
				$lista .= str_replace('<?xml version="1.0"?>', '', $item->asXML());
			}
			return $lista;
		}
		
		public function asArray() {
			$lista = $this->lista;
			foreach ($lista as &$item) {
				$item = $item->asArray();
			}
			return (array)$lista;
		}
	}
?>