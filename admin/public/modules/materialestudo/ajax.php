<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new MaterialEstudo;
	
	$modulo = 'materialestudo';
	
	if($_GET){

		$registros = $class->getBy(
    	    $dados = array(
        	    'materialestudo.status' => 1
    	    ),
    	    $campos = array(
        	    'materialestudo.*',
        	    'materialestudo.id AS DT_RowId',
        	    'disciplina.id AS id_disciplina',
        	    'disciplina.titulo AS disciplina_titulo',
        	    'materia.id AS id_materia',
        	    'materia.titulo AS materia_titulo',
//         	    'topico.titulo AS topico_titulo',
        	    'CONCAT(disciplina.titulo, " -> ", materia.titulo) AS caminho_topico'
    	    ),
    	    $inner = array(
/*
        	    'topico' => array(
            	    'topico.id' => 'materialestudo.id_topico'
        	    ),
*/
        	    'materia' => array(
            	    'materia.id' => 'materialestudo.id_materia'
        	    ),
        	    'disciplina' => array(
            	    'disciplina.id' => 'materia.id_disciplina'
        	    )
    	    ),
    	    $left   = false,
    		$groupBy= false,
    		$having = false,
    		$orderBy= 'materialestudo.id DESC'
    	);		
    	die(data($registros));
	}
	
	
	if($_POST){
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
		
		//filterArray(array('titulo', 'texto', 'sub_titulo'), $dados);
		
		$dados['demonstrativo'] = isset( $dados['demonstrativo'] ) ? 1 : 0;
		
		switch ($acao) {
			case 'criar' :

				$success = $class->insert($dados, false);
				$class->ajustarOrdem($success, $dados["ordem"], $dados["id_materia"]);
				if(!$success) {
					$Resposta->insert('Erro ao cadastrar registro.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					
					break;
				}
				
				$Resposta->insert('Registro cadastrado com sucesso.', Resposta::SUCCESS);
				
				break;
			case 'editar' :
				
				$success = $class->update($_POST["id"], $dados, false);
				$class->ajustarOrdem($_POST["id"], $dados["ordem"], $dados["id_materia"]);
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
				
			case 'ordem' :
				$ordens = $_POST['order'];
								
				foreach($ordens as $i => $item){
					
					$success = $class->update($item, array('ordem' => $i), false);
					
				}
				
				if(!$success) {
					$Resposta->insert('Erro na tentativa de editar.', Resposta::ERROR);
					$Resposta->insert('Tente novamente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				$Resposta->insert('Ordem alterada com sucesso.', Resposta::SUCCESS);
				
				break;
		}			
	}
	
?>