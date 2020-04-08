<?php
	class SeoUrl extends Signoweb {
		public $orderby = "id ASC";
		public $tabela = 'seo_url';
		
		public function getIdentificador($origem) {
			$sql = 
				'SELECT * FROM seo_url WHERE origem = ? AND TRIM(destino) != ""';
			$this->args = array($origem);
			return $this->executaSqlUnica($sql);
		}
		
		public function getByDestino($destino) {
			$sql = 
				'SELECT * FROM seo_url WHERE destino = ?';
			
			return $this->run($sql, array($destino));
		}
		
		public function getByOrigem($origem) {
			$sql = 
				'SELECT * FROM seo_url WHERE origem = ?';
			
			return $this->run($sql, array($origem));
		}
	}
?>