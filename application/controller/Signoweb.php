<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Connection.php';
/*
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/application/controllers/Upload.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/application/controllers/Arquivo.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/application/controllers/SMTP.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/application/controllers/PHPMailer.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/application/controllers/Email.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/application/controllers/Funcoes.php';
*/
	
	abstract class Signoweb {
		var $tabela;			// string !!!!Obrigatório!!!!

	    public function __construct(){
		    if (empty($this->tabela))
			    throw new Exception('Preencha/crie o campo "public $tabela" da classe '.get_called_class());
	    }
	    
	    public function listAll() {
    	    return $this->getBy(
        	    array(
            	    'status' => 1
        	    ),
        	    array(
            	    '*',
            	    'id as DT_RowId'
        	    )
    	    );
	    }
	    
	    public function getFirst() {
    	    $r = $this->getBy(
        	    $dados = array(
            	    'status' => 1
        	    ),
                $campos = array(
            	    '*',
            	    'id as DT_RowId'
        	    ),
        	    $inner = false,
        	    $left = false,
        	    $groupBy = false,
        	    $having = false,
        	    $orderBy = 'id DESC'
    	    );
    	    
    	    return end($r);
	    }
	    
	    public function nextOrder() {
    	    $ordem = $this->getBy(
        	    $dados = array(
            	    'status' => 1
        	    ),
        	    $campos = array(
            	    "MAX(ordem) as ordem",
        	    )
    	    );
    	    
    	    if( $ordem == FALSE) $ordem = -1;    	
    	    if( end($ordem)['ordem'] === FALSE || end($ordem)['ordem'] === NULL) $ordem = -1;
    	    if( is_numeric(end($ordem)['ordem']) ) $ordem = end($ordem)['ordem'];
    	    

    	    return $ordem + 1;
	    }
		
		public function getBy($dados = array(), $campos = array('*'), $inner = array(), $left = array(), $groupBy = '', $having = '', $orderBy = '') {
			$args = array();
			$campos = implode(',', $campos);
			$sql = "SELECT {$campos} FROM {$this->tabela} ";
			
			if ($inner) {
				foreach ($inner as $tabela => $condicoes) {
					$sql .= " INNER JOIN {$tabela} ON ";
					$conds = array();
					foreach ($condicoes as $campo1 => $campo2) {
						$conds[] = "({$campo1} = {$campo2})";
					}
					$sql .= implode(' AND ', $conds);
				}
			}
			
			if ($left) {
				foreach ($left as $tabela => $condicoes) {
					$sql .= " LEFT JOIN {$tabela} ON ";
					$conds = array();
					foreach ($condicoes as $campo1 => $campo2) {
						$conds[] = "({$campo1} = {$campo2})";
					}
					$sql .= implode(' AND ', $conds);
				}
			}
			
			if ($dados) {
				$sql .= ' WHERE ';
				$condicoes = array();
				foreach ($dados as $campo => $valor) {
					if (is_array($valor)) {
						$condicoes[] = "($campo IN (" . implode(',', array_fill(0, sizeof($valor), '?')) . "))";
						$args = array_merge($args, $valor);
					} else {
						$condicoes[] = "($campo = ?)";
						$args[] = $valor;
					}
				}
				$sql .= implode(' AND ', $condicoes);
			}
			
			if ($groupBy)
				$sql .= ' GROUP BY ' . $groupBy . ' ';
				
			if ($having)
				$sql .= ' HAVING ' . $having . ' ';
			
			if ($orderBy)
				$sql .= ' ORDER BY ' . $orderBy . ' ';
			//var_dump($sql);
			$conexao = new Connection();
			
			//var_dump($sql);
			
			return $conexao->run($sql, $args);
		}

		public function getGroupingBy($campoAgrupador, $dados = array(), $campos = array('*'), $inner = array(), $left = array(), $groupBy = '', $having = '', $orderBy = ''){
			$args = array();
			$campos = implode(',', $campos);
			$sql = "SELECT {$campos} FROM {$this->tabela} ";
			
			if ($inner) {
				foreach ($inner as $tabela => $condicoes) {
					$sql .= " INNER JOIN {$tabela} ON ";
					$conds = array();
					foreach ($condicoes as $campo1 => $campo2) {
						$conds[] = "({$campo1} = {$campo2})";
					}
					$sql .= implode(' AND ', $conds);
				}
			}
			
			if ($left) {
				foreach ($left as $tabela => $condicoes) {
					$sql .= " LEFT JOIN {$tabela} ON ";
					$conds = array();
					foreach ($condicoes as $campo1 => $campo2) {
						$conds[] = "({$campo1} = {$campo2})";
					}
					$sql .= implode(' AND ', $conds);
				}
			}
			
			if ($dados) {
				$sql .= ' WHERE ';
				foreach ($dados as $campo => $valor) {
					if (is_array($valor)) {
						$condicoes[] = "($campo IN (" . implode(',', array_fill(0, sizeof($valor), '?')) . "))";
						$args = array_merge($args, $valor);
					} else {
						$condicoes[] = "($campo = ?)";
						$args[] = $valor;
					}
				}
				$sql .= implode(' AND ', $condicoes);
			}
			
			if ($groupBy)
				$sql .= ' GROUP BY ' . $groupBy . ' ';
				
			if ($having)
				$sql .= ' HAVING ' . $having . ' ';
			
			if ($orderBy)
				$sql .= ' ORDER BY ' . $orderBy . ' ';

			$conexao = new Connection;			
			return $conexao->runGrouping($sql, $args, $campoAgrupador);
		}

		public function getById($id){
			$sql = 
				"SELECT
					*
				FROM {$this->tabela}
				WHERE
					id = ?";
			
			$conexao = new Connection;
			list($registro) = $conexao->run($sql, array($id));
			return $registro;
		}
		
		public function getByIdPagina($id){
			$sql = 
				"SELECT
					*
				FROM {$this->tabela}
				WHERE
					id = ? AND bloqueado != 1";
			
			$conexao = new Connection;
			list($registro) = $conexao->run($sql, array($id));
			return $registro;
		}
		
		public function insert($dados, $filter = true){ // @param Array
			if ($filter)
				$dados = arrayToFunction('htmlspecialchars', $dados);
				
			$conexao = new Connection;
			
			return $conexao->inserirRegistro($this->tabela, $dados);
		}
		
		public function update($id, $dados, $filter = true) {
			if ($filter)
				$dados = arrayToFunction('htmlspecialchars', $dados);
				
			$conexao = new Connection;
			return $conexao->alterarRegistro($this->tabela, $dados, 'id = ?', array($id));
		}
		
		public function deleteById($id){
			$conexao = new Connection;
			return $conexao->alterarRegistro($this->tabela, array('status' => 0), 'id = ?', array($id));
		}
		
		public function deleteByIdPagina($id){
			$conexao = new Connection;
			return $conexao->alterarRegistro($this->tabela, array('status' => 0), 'id = ? AND bloqueado != 1', array($id));
		}
		
		public function deleteBy($dados){
			$sql = 'UPDATE ' . $this->tabela . ' SET status = 0 WHERE ';
			foreach ($dados as $campo => $valor) {
				if (is_array($valor)) {
					$condicoes[] = "$campo IN (?)";
					$args[] = implode(',',$valor);
				} else {
					$condicoes[] = "$campo = ?";
					$args[] = $valor;
				}
			}
			$sql .= implode(' AND ', $condicoes);

			$conexao = new Connection;
			return $conexao->alterarRegistro($this->tabela, array('status' => 0), implode(' AND ', $condicoes), $args);
		}
		
		// É recomendado passar o $_GET como argumento
		public function listarDataTable($request = null){
			if (is_null($request)) $request = $_REQUEST;
			
			$column = $request['columns'][$request['order'][0]['column']]['name'];
			$order = (empty($column) ? $this->tabela.'.id DESC' : $this->tabela.'.'.$column.' '.$request['order'][0]['dir']);
			
			$limit = $request['start'].', '.$request['length'];
			
			$search = $request['search']['value'];
			
			$args = array();
			foreach ($request['columns'] as $col) {
				if (empty($col['name'])) continue;
				$buscarPor[] = $col['name'].' LIKE ?';
				$args[] = "%$search%";
				$campos[] = $col['name'].' as '.$col['data'];
			}
			
			$sql = 'SELECT '.implode(', ', $campos)." FROM {$this->tabela} WHERE status = 1 AND (".implode(' OR ', $buscarPor).") ORDER BY $order LIMIT $limit";
			
			$conexao = new Connection();
			$refistros = $conexao->run($sql, $args);
			
			$sql = 'SELECT COUNT(id) FROM '.$this->tabela.' WHERE status = 1 AND ('.implode(' OR ', $buscarPor).')';
			list($retorno) = $conexao->run($sql);
			$contador = current($retorno);
			
			$dados = json_encode(array(
				'draw'				=>	$request['draw'],
				'recordsTotal'		=>	$contador,
				'recordsFiltered'	=>	$contador,
				'data'				=>	$registros
			));
			return $dados;
		}
		
		public function run($sql, $args, $crud = 's') {
    		$conexao = new Connection;
    		return $conexao->run($sql, $args, $crud);
		}
		
	}	
	
?>