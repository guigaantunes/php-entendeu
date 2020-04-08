<?
function conectar($servidor = SERVIDOR, $bancoDeDados = BANCODEDADOS, $usuario = USUARIO, $senha = SENHA)
{
    /* retorna link de conexao */
    $pdo = new PDO("mysql:host=$servidor;dbname=$bancoDeDados;charset=utf8mb4", $usuario, $senha,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    if (is_bool($pdo)) {
	    var_dump($pdo->errorInfo());
	    die();
	}
    return $pdo;
}

function desconectar(&$conexao)
{
    /* deconecta com o banco da de dados */
    $conexao = null;
}

function logs(&$conexao, $id_origem, $tabela, $acao){
	$sql = "INSERT INTO logs (id_origem, id_usuario, tabela, acao, ip) values ('$id_origem', '".$_SESSION['admin']['id']."', '$tabela', '$acao', '".$_SERVER['REMOTE_ADDR']."');";
    executaSql($conexao, $sql, array(), 'i');
}

function executaSql(&$conexao, $sql, $conditions = array(), $crud = '') {
	/*
	* $conexao  		Algum retorno da função "conectar"
	* $sql 				A query
	* $conditions  		Uma array com os valores das condições
	* $crud				Se foi insert, select, update ou delete
	*/
	
	$sth = $conexao->prepare($sql); // Prepara o SQL
	if (!$sth) {
		$error = $conexao->errorInfo();
		mail(EMAIL_DEBUG, 'Bee Con '.__LINE__, print_r(array($error, $sql),true));
		return $error;
	}
	
	if (!$sth->execute($conditions)) { // Executa
		$error = $sth->errorInfo();
		$sth->closeCursor(); // Fecha (nem sempre necessário)
		$sth = null; // Fecha (necessário)
		mail(EMAIL_DEBUG, 'Bee SQL '.__LINE__, print_r(array($error, $sql),true));
		return $error;
	}
	
	$resultSel = $sth->fetchAll(PDO::FETCH_ASSOC); // Pega os resultados
	$id = $conexao->lastInsertId();
	$sth->closeCursor(); // Fecha (nem sempre necessário)
	$sth = null; // Fecha (necessário)
	
	/*mail(EMAIL_DEBUG, __FILE__." ".__LINE__, "Sel: ".print_r($resultSel, true)."
	id: ".$id."
	sql: ".print_r($sql, true)."
	error: ".print_r($error, true));/**/
	//var_dump($resultSel);
	if ($crud == '' || $crud == 's')
		return $resultSel;
	
	if($crud == 'i')
		return $id;
		
	return true;
} 

function inserirRegistro(&$conexao, $tabela, $vetor, $sqlE="")
{
    /* formando string dos campos e valores */
    foreach ($vetor as $campo => $valor) {
        @$campos .= $campo;
        @$valores .= "'" . addslashes($valor) . "'";

        if (@$i++ < count($vetor)-1) {
			$campos .= ', ';
			$valores .= ', ';
        } 
    }

    /* formando query do sql */
    $sql = 'INSERT INTO ' . $tabela . ' (' . $campos . ') values (' . $valores . ');';
	//echo "Inserir: ".$sql."<br>"; break;
	
	if ($sqlE) {
		echo "Inserir:".$sql;
		//break;
	}

    /* executando query de sql */
    $id = executaSql($conexao, $sql, array(), 'i');
    
    logs($conexao, $id, $tabela, 'INSERIR');
    
    return $id;
}


function alterarRegistro(&$conexao, $tabela, $campo_id, $valor_id, $vetor)
{
    /* formando string do campos e valores */
    foreach ($vetor as $campo => $valor) {
        @$strQuery .= $campo . '=\'' . addslashes($valor) . '\'';
        if (@$i++ < count($vetor)-1) {
            $strQuery .= ', ';
        }
    }
    /* formando query do sql */
    $sql = 'UPDATE ' . $tabela . ' SET ' . $strQuery . ' WHERE ' . $campo_id . '=\'' . $valor_id . '\';';

    //echo $sql; break;

    /* executando query de sql */
    $sucess = executaSql($conexao, $sql, array(), 'u');
    
    logs($conexao, $valor_id, $tabela, 'ALTERAR');
    
    return $sucess;
}

function excluirRegistro(&$conexao, $tabela, $campo_id, $valor_id)
{
    /* formando query do sql */
    $sql = 'UPDATE ' . $tabela . ' SET status = 0 WHERE ' . $campo_id . '=\'' . $valor_id . '\';';

    /* executando query de sql */
    $sucess = executaSql($conexao, $sql, array(), 'd');
    
    logs($conexao, $valor_id, $tabela, 'INATIVAR');
    
    return $sucess;
}

function excluirTotalmenteRegistro(&$conexao, $tabela, $campo_id, $valor_id)
{
    /* formando query do sql */
    $sql = 'DELETE FROM ' . $tabela . ' WHERE ' . $campo_id . '=\'' . $valor_id . '\';';

    /* executando query de sql */
    $sucess = executaSql($conexao, $sql, array(), 'd');
    
    logs($conexao, $valor_id, $tabela, 'DELETAR');
    
    return $sucess;
}

function registro(&$conexao, $tabela, $campos = "1", $valores = "1", $vetor = '*') {
    /* formando query do sql */
	$sql = 'SELECT '.camposConsultaHtmlSql($vetor).' FROM ' . $tabela . ' WHERE ';
	if (is_array($campos)) {
		$sql .= camposConsultaCondicoes($campos, $valores);
	} elseif (is_array($valores)) {
		$sql .= "$campos IN (".camposConsultaHtmlSql($valores, true).") ";
	} else {
		$sql .= "$campos = '$valores'";
	}
	
	#mail("davi@signoweb.com.br", __FILE__." ".__LINE__, print_r($sql, true));
    /* monta vetor e retorna*/	
    return executaSql($conexao, $sql);
}

function camposConsultaCondicoes($campos, $valores) {
	$retorno = '';
	$tam = sizeof($campos) - 1;
	foreach ($campos as $i => $campo) {
		$retorno .= $campo." = '".$valores[$i]."' ";
		if ($i != $tam) {
			$retorno .= "AND ";
		}
	}
	return $retorno;
}

function camposConsultaHtmlSql($vetor, $aspas = false)
{
	if($vetor != "*")
	{
		//select [campo1, campo2] from tabela
		$retorno = "";
		$totalElementos = count($vetor);
		while(list($chave, $valor) = each($vetor))
		{
			$retorno .= ($aspas ? "'$valor'" : $valor);
			if($totalElementos > 1)
				$retorno .= ", ";
			$totalElementos--;
		}
		return $retorno;
	}
	
		return "*";
}
?>