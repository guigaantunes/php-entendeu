<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	
	includeClasses('Resposta', 'Upload');
	necessitaLogin();
	
	$class = new Arquivo;
	$Resposta = new Resposta;
	
	try {
		if ($_FILES) {
			$id = $_REQUEST['dados']["id_referencia"];
			$tabela = $_REQUEST['dados']["tabela"];
			$tipo = $_REQUEST['dados']["tipo"];
			
			$limite = $IMAGENS[$tabela][$tipo]['limite'];
			var_dump($limite);
			$listaImagems = $class->getBy(array(
				'id_referencia'		=> $id,
				'tabela'			=> $tabela,
				'tipo'				=> $tipo
			));
			
			if (sizeof($listaImagems) >= $limite) {
				$Resposta->insert('Limite de imagens atingido', 'error');
				$Resposta->setStatus(false);
				die();
			}
			
			$success = $class->upload($_FILES['file'], $tabela, $id, $tipo);
			
			if (!$success) {
				$Resposta->insert('Erro ao salvar arquivos', 'error');
				$Resposta->setStatus(false);
			} else {
				$pesquisarPor = array(
					'tabela'		=> $tabela,
					'id_referencia'	=> $id
				);
				
				if ($tipo)
					$pesquisarPor['tipo'] = $tipo;
				
				$arquivos = $class->getBy($pesquisarPor);
				$Resposta->insert('Enviado com sucesso!', 'success');
				$Resposta->add('arquivos', $arquivos);
			}
			
		} else if($_POST){
			$acao = $_POST['acao'];
			$dados = $_POST['dados'];
			filterArray(array('nome', 'email', 'senha', 'id_nivel'), $dados);
					
			switch ($acao) {
				case 'excluir' :
					$idArquivo = $_POST['id'];
					$success = $class->deleteById($idArquivo);
					
					if($success) {
						$Resposta->insert('Excluído com sucesso.', Resposta::SUCCESS);
					} else {
						$Resposta->insert('Erro ao excluir.', Resposta::ERROR);
						$Resposta->insert('Tente novamente.', Resposta::ERROR);
						$Resposta->setStatus(false);
					}
					
					break;
			}			
		}
	} catch (FileUploadException $e) {
		$Resposta->insert('Erro ao salvar arquivos', 'error');
		$Resposta->add('erro', $e->getMessage());
		$Resposta->add('exception', get_class($e));
		$Resposta->setStatus(false);
	} catch (Throwable $e) {
		$Resposta->insert('Erro ao salvar arquivos', 'error');
		$Resposta->add('erro', $e->getMessage());
		$Resposta->add('exception', get_class($e));
		$Resposta->setStatus(false);
	} catch (Exception $e) {
		$Resposta->insert('Erro ao salvar arquivos', 'error');
		$Resposta->add('erro', $e->getMessage());
		$Resposta->add('exception', get_class($e));
		$Resposta->setStatus(false);
	}
	
?>