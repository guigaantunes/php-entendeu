<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new Topico;
	
	$modulo = 'topico';
	
	if($_GET){
    	
    	$idMateria = $_REQUEST['idMateria'];

		$registros = $class->getBy(
		    $dados = array(
			    'topico.status' => 1,
                'topico.id_materia' => $idMateria
            ),
    		$campos = array(
    			'topico.*',
    			'topico.id AS DT_RowId',
    			'materia.titulo as materia'
    		),
    		$inner  = array(
        		'materia' => array(
            		'materia.id' => 'topico.id_materia'
        		)
    		),
    		$left   = false,
    		$groupBy= false,
    		$having = false,
    		$orderBy= "materia.ordem ASC"
        );
		die(data($registros));
	}
	
	
	if($_POST){
		$Resposta   = new Resposta;
		$acao       = $_POST['acao'];
		$dados      = $_POST['dados'];
		
		//filterArray(array('titulo', 'texto', 'sub_titulo'), $dados);
		
		switch ($acao) {
			case 'criar' :

				$success = $class->insert($dados, false);
				
				
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