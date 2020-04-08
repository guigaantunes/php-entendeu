<?php 
	/*
	* v1.2.2
	*/
	class Resposta {
		private $respostas = array();
		private $dados = array();
		private $status = true;
		
		static  $autoprint = true;
		
		const SUCCESS = 'success';
		const ERROR = 'error';
		const WARNING = 'warning';
		
		function __construct($msg = '', $status = '', $tempo = 3000) {
			if (!empty($msg)) $this->insert($msg, $status, $tempo);
		}
		
		function insert($msg = 'Processando...', $status = '', $tempo = 3000) {
			$this->respostas[] = array(
				'mensagem' => $msg,
				'tempo' => $tempo,
				'tipo' => $status
			);	
			//return $id;
			return TRUE;
		}
		
		function add($stringName, $mixedValue) {
			$this->dados[$stringName] = $mixedValue;
		}
		
		function setStatus($boolStatus) {
			$this->status = $boolStatus;
		}
		
		function __destruct() {
    		if (self::$autoprint) {
			    $this->printIt();
			}
		}
		
		function printIt() {
			echo json_encode(array('mensagens' => $this->respostas, 'dados' => $this->dados, 'status' => $this->status));
		}
	}
?>