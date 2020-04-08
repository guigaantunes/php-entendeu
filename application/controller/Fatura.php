<?php 
	class Fatura extends Signoweb {
		var $tabela = 'fatura';	
		
		public function getFatura($id_cliente=false) {
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		$sql = "SELECT * FROM {$this->tabela} WHERE status = 1 AND id_cliente = {$id_cliente} ORDER BY id ASC";
    		$retorno = $this->run($sql, array());
    		$retorno = end($retorno);
    		
    		return $retorno;
		}

/*
		public function temAssinatura($id_cliente=false) {
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		$sql = "SELECT * FROM {$this->tabela} WHERE status = 1 AND id_cliente = {$id_cliente}";
    		$retorno = $this->run($sql, array());
    		$retorno = end($retorno);
    		
    		return !!$retorno;
		}
		
		public function getAssinatura($id_cliente=false) {
    		$id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
    		if (!$id_cliente) return false;
    		
    		$sql = "SELECT * FROM {$this->tabela} WHERE status = 1 AND id_cliente = {$id_cliente} ORDER BY id ASC";
    		$retorno = $this->run($sql, array());
    		$retorno = end($retorno);
    		
    		return $retorno;
		}
*/
	}
?>