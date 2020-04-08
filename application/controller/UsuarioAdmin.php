<?php 
	class UsuarioAdmin extends Signoweb {
		var $tabela = 'usuario';
		
		public function insert($data, $filter = true){
			if ($data['senha'])
				$data['senha'] = pass($data['senha']);
			
			return parent::insert($data, $filter);
		}
		
		public function update($id, $data, $filter = true){
			if ($data['senha'])
				$data['senha'] = pass($data['senha']);
			
			return parent::update($id, $data, $filter);
		}
		
		public function login($email, $senha) {
			$login = $this->getBy(array(
				'email'	=> $email,
				'senha' => pass($senha),
				'status'=> 1
			));
			return end($login);
		}
	}
?>