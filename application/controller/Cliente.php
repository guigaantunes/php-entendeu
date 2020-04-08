<?php 
	class Cliente extends Signoweb {
		var $tabela = 'cliente';
				
		public function login($email, $senha) {
			$login = $this->getBy(array(
				'email'	=> $email,
				'senha' => pass($senha),
				'status'=> 1
			));
			
			return end($login);
		}
		
		public function emailExiste($email, $id=FALSE) {
    		$sql = "
    		    SELECT * FROM cliente WHERE status = 1 AND email = '$email' 
    		".($id ? " AND id != $id" : '');
    		
    		$result = $this->run($sql, array());

    		return (bool)$result;
		}
		
	}
?>