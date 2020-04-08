<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new Plano;
	$modulo = "cliente";	
		
	if($_GET){
    	
    	$registros = $class->getBy(
		    $dados = array(
			    'status' => 1
            ),
    		$campos = array(
    			'*',
    			'id AS DT_RowId',
    			'FORMAT(valor_basico/100,2) as valor_basico',
    			'FORMAT(valor_vip/100,2)    as valor_vip'
            ),
    		$inner  = false,
    		$left   = false,
    		$groupBy= false,
    		$having = false,
    		$orderBy= " ordem ASC "
        );

		echo data($registros);
	}
	
	if($_POST){
		
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
		//filterArray(array('nome', 'email', 'senha', 'id_nivel'), $dados);
				
        $dados['valor_basico']  = soNumeros($dados['valor_basico']);
        $dados['valor_vip']     = soNumeros($dados['valor_vip']);
        
        $dados['ativo']         = isset($dados['ativo']) ? 1 : 0;
        
		switch ($acao) {
			case 'criar' :
				
				$success = $class->insert($dados);
				
				if(!$success) {
					$Resposta->insert('Erro ao criar registro.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Registro criado com sucesso.', Resposta::SUCCESS);	
				break;
			case 'editar' :
				
				$success = $class->update($_POST["id"], $dados);
				
				if(!$success) {
					$Resposta->insert('Erro ao editar registro.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Registro alterado com sucesso.', Resposta::SUCCESS);				
				break;
			case 'excluir' :
				
				$success = $class->deleteById($_POST["id"]);
				
				if(!$success) {
					$Resposta->insert('Erro na tentativa de exclusão.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Registro excluído com sucesso.', Resposta::SUCCESS);
				break;
		}			
	}
	
?>