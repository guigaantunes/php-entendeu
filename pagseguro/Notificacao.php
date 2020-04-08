<?php
	// Transparente
	require_once 'Pagseguro.php';
	class PagSeguroNotificacao extends PagSeguro {
		public function consultaTransacao($notificationCode) {
			$transaction = $this->request("/v3/transactions/notifications/".$notificationCode, 'GET');
			$this->log(var_export($transaction, true));
			return $transaction;
		}
		
		public function consultaPreapproval($notificationCode) {
			$transaction = $this->request("/pre-approvals/notifications/".$notificationCode, 'GET', array(), 'JSON');
			$this->log(var_export($transaction, true));
			return $transaction;
		}
	}
?>