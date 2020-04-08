<?php 
	/**
	 * Classe de conexão com o banco
	 *
	 * @extends PDO
	 */
	class Connection extends PDO {
		static $DEBUG = false;
		private $protected;
		
		public function __construct($servidor = SERVIDOR, $bancoDeDados = BANCODEDADOS, $usuario = USUARIO, $senha = SENHA, $charset = 'utf8mb4') {
			parent::__construct("mysql:host=$servidor;dbname=$bancoDeDados;charset=$charset", $usuario, $senha,
		                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '$charset'", 
		                          PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names='pt_BR',NAMES utf8")
            );
            
		    $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		
		/**
		* Função que executa uma sql normalmente
		*
		* @param string $sql A sql a ser rodada
		* @param array $args Argumentos a serem inseridos na sql (substituirão os ?)
		* @param char $crud Se foi insert, select, update ou delete (influencia no retorno)
		*/
		public function run($sql, $args, $crud = 's') {
			if (self::$DEBUG)
				$this->file_log(print_r(array($sql, $args),true));
			
			$sth = $this->prepare($sql); // Prepara o SQL
			if (!$sth) {
				$error = $this->errorInfo();
				$this->file_log(print_r(array($error, $sql, $args),true));
				
				return false;
			}
			
			if (!$sth->execute($args)) { // Executa
				$error = $sth->errorInfo();
				$sth = null;
				$this->file_log(print_r(array($error, $sql, $args),true));
				//var_dump('falseee');
				return false;
			}
			
			$resultSel = $sth->fetchAll(PDO::FETCH_ASSOC); // Pega os resultados
			$id = $this->lastInsertId();
			$sth = null; // Fecha (necessário)
			
			if ($crud == 's')
				return $resultSel;
			
			if ($crud == 'i')
				return $id;
				
			return true;
		}
		
		/**
		* Retorna uma lista de registros, porém ajustada para se agrupar numa matriz de acordo com algum parâmetro
		*
		* @param string $sql A sql a ser rodada
		* @param array $args Argumentos a serem inseridos na sql (substituirão os ?)
		* @param string $group Nome do campo para agrupar os resultados
		* @param char $crud Se foi insert, select, update ou delete (influencia no retorno)
		*/
		public function runGrouping($sql, $args, $group, $crud = 's') {
			if ($this->DEBUG)
				$this->file_log(print_r(array($sql, $args),true));
			
			$sth = $this->prepare($sql); // Prepara o SQL
			if (!$sth) {
				$error = $this->errorInfo();
				$this->file_log(print_r(array($error, $sql, $args),true));
				return false;
			}
			
			if (!$sth->execute($args)) { // Executa
				$error = $sth->errorInfo();
				$sth = null;
				$this->file_log(print_r(array($error, $sql, $args),true));
				return false;
			}
			
			$resultSel = array();
			while ($row = $sth->fetch()) {
				$resultSel[$row[$group]][] = $row; 
			}
			
			$id = $this->lastInsertId();
			$sth = null; // Fecha (necessário)
			
			if ($crud == 's')
				return $resultSel;
			
			if ($crud == 'i')
				return $id;
				
			return true;
		}
		
		/*
		 * $vetor = array(
		 *		id => 12
		 *		nome => paulo
		 *		...
		 */
		public function inserirRegistro($tabela, $vetor)
		{
			$args = array();
		    foreach ($vetor as $campo => $valor) {
		        @$campos .= $campo;
		        @$valores .= "?";
		        @$args[] = $valor;
		
		        if (@$i++ < count($vetor)-1) {
					$campos .= ', ';
					$valores .= ', ';
		        } 
		    }
		
		    /* formando query do sql */
		    $sql = 'INSERT INTO ' . $tabela . ' (' . $campos . ') values (' . $valores . ');';
		
		    /* executando query de sql */
		    $id = $this->run($sql, $args, 'i');
		    
		    return $id;
		}
		
		
		public function alterarRegistro($tabela, $dados, $where = '', $whereArgs = array())
		{
		    $commonArgs = array();
		    foreach ($dados as $campo => $valor) {
		        @$strQuery .= $campo . ' = ? ';
		        @$commonArgs[] = $valor;
		        if (@$i++ < count($dados)-1) {
		            $strQuery .= ', ';
		        }
		    }
		    
		    $sql = 'UPDATE ' . $tabela . ' SET ' . $strQuery;
		    if ($where)
		    	$sql .= " WHERE {$where}";
		    
			$args = array_merge($commonArgs, $whereArgs);
		    $success = $this->run($sql, $args, 'u');
		    return $success;
		}
		
		public function excluirTotalmenteRegistro()
		{
		    $sql = "DELETE FROM {$this->tabela} WHERE id = ?";
		    $args = array($this->id);
		    $success = $this->run($sql, $args, 'd');
		    return $success;
		}
		
		public function file_log($text) {
			error_log(date('Y-m-d H:i:s ').$text."\n ".get_called_class()."\n\n", 3, $_SERVER['DOCUMENT_ROOT'].'/database.log');
		}
	}
	
	class ConexaoException extends Exception {}
?>