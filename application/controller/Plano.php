<?php 
	class Plano extends Signoweb {
		var $tabela = 'plano';
		
		public function listarPlanosDisponiveis() {
    		return $this->getBy(
                $dados = array(
                    'status' => 1,
                    'ativo' => 1
                ),
                $campos = array(
                    '*'
                ),
                $inner  = false,
                $left   = false,
                $groupBy= false,
                $having = false,
                $orderBy= 'ordem ASC'
            );
		}
	}
?>