<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta');
	necessitaLogin();
	
	$class = new Blog;
	
	$modulo = 'blog';
	
	if($_GET){

		$resgistros = $class->getBy(
		    $dados = array(
			    'blog.status' => 1
            ),
    		$campos = array(
    			'blog.*',
    			'blog.id AS DT_RowId',
    			'usuario.nome as usuario',
    	    'categoria_blog.titulo AS categoria',
    	    'CONCAT("<span style=\'color:#aaa\'>'.URL_SITE.'conteudo/</span>", blog.url) as url'
    		),
    		$inner = array(
        		'usuario' => array(
            		'usuario.id' => 'blog.id_usuario'
        		),
        		'categoria_blog' => array(
            		'categoria_blog.id' => 'blog.id_categoria'
        		)
    		),
    		$left   = false,
    		$groupBy= false,
    		$having = false,
    		$orderBy = 'blog.id DESC'
		);
		die(data($resgistros));
	}
	
	
	if($_POST){
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
		
		//filterArray(array('titulo', 'texto', 'sub_titulo'), $dados);
		
		switch ($acao) {
			case 'criar' :
			
			$dados['id_usuario'] = $_SESSION['admin']['id'];

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