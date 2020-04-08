<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ajax/lib/ApiMailchimp.php');
	ob_start();
	
	includeClasses('Resposta');
	//necessitaLogin();
	$MailChimp          = new MailChimp(MAILCHIMP_KEY);
	$class              = new Cliente;
	$classAssinatura    = new Assinatura;
	$Pagseguro          = new PagSeguroRecorrencia;
	$modulo = "cliente";	
	
	
		
	if($_GET){
		
		$registros = $class->getBy(
		    $dados = array(
			    'cliente.status' => 1
            ),
            $campos = array(
    			'cliente.*',
    			'cliente.id AS DT_RowId',
    			'DATE_FORMAT(cliente.data_cadastro, "%d/%m/%Y %H:%i:%s") as data_cadastro_f',
    			'IF(assinatura.id, "Sim", "Não") as assinaturaAtiva'
            ),
            $inner  = false,
            $left   = array(
                'assinatura' => array(
                    'assinatura.id_cliente' => 'cliente.id',
                    //'assinatura.status'     => 1
                )
            ),
            $groupBy= false,
            $having = false,
            $orderBy= 'id DESC'
		);
		$MailChimp->call('lists/subscribe', array(
                    'id' => MAILCHIMP_LIST_ID,
                    'email' => array('email' => $dados['email']),
                    'merge_vars' => array('FNAME' => $dados['Nome'], 'PHONE' => $dados['Telefone']),
                    'double_optin' => MAILCHIMP_DOUBLE_OPTIN, //CONFIRMAÇÃO DE EMAIL
                    'update_existing' => MAILCHIMP_UPDATE_EXISTING, //ATUALIZAR LEAD EXISTENTE
                    'replace_interests' => false,
                    'send_welcome' => false,
                        ));
	
/*	foreach($registros as $i => $r) {
      $registros[$i]['tipoDeAcesso'] = (temAcessoBasico($r['id'])) ? 'Basico' : 'Sem Assinatura';
      $registros[$i]['tipoDeAcesso'] = (temAcessoVip($r['id'])) ? 'Vip' : $registros[$i]['tipoDeAcesso'];
		}*/
	//var_dump ($classAssinatura->temAcessoBasico(853));
		echo data($registros);
	}
	
	if($_POST){
		
		$Resposta = new Resposta;
		$acao = $_POST['acao'];
		$dados = $_POST['dados'];
		//filterArray(array('nome', 'email', 'senha', 'id_nivel'), $dados);
		
		//$dados['vip']   = (isset($dados['vip']) ? 1 : 0);
		$dados['senha'] = trim($dados['senha']);
		$dados['csenha']= trim($dados['csenha']);
		
		$dados['ativacao_manual']   = isset($dados['ativacao_manual'])  ? 1 : 0;
		$dados['acesso_vip_manual'] = $dados['ativacao_manual'] && isset($dados['acesso_vip_manual']) ? 1 : 0;
		
						
		switch ($acao) {
			case 'criar' :
				
				list($usuarios) = $class->getBy(array(
					'status'	=>	1,
					'email'		=> $dados['email']
				));
				
				if (sizeof($usuarios) > 0) {
					$Resposta->insert('Já existe um usuário com esse email', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				if (strlen($dados['senha']) == 0 ) {
    				$Resposta->insert('Senha deve ser preenchida', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				if ( $dados['senha'] != $dados['csenha'] ) {
    				$Resposta->insert('Senha não coincidem', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}
				
				unset($dados['csenha']);
				
				$dados['senha'] = md5($dados['senha']);
				
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
				
/*
				if($dados["senha"] == "") {
					unset($dados["senha"]);	
				} else {
    				$dados["senha"] = md5($dados["senha"]);
				}
*/
				
				$emailExiste = $class->emailExiste($dados['email'], $_POST['id']);

				/*if ($emailExiste) {
    				$Resposta->insert('Erro ao editar registro.', Resposta::ERROR);
					$Resposta->insert('Este e-mail já está registrado para outro cliente.', Resposta::ERROR);
					$Resposta->setStatus(false);
					break;
				}*/
				
				if(strlen($dados['senha']) > 0) {
    				if ( $dados['senha'] != $dados['csenha'] ) {
        				$Resposta->insert('Senha não coincidem', Resposta::ERROR);
    					$Resposta->setStatus(false);
    					break;
    				}
    				
    				$dados['senha'] = md5($dados['senha']);
				} else {
    				unset($dados['senha']);
				}
				
				unset($dados['csenha']);
				
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
            case 'cancelar-assinatura':
                $id = $_POST['id'];
                
                $assinatura         = $classAssinatura->getAssinatura($id);
            	$assinaturaAtiva    = $classAssinatura->assinaturaAtiva($id);
            	
            	if ($assinatura) {
                    $cancelamento = $Pagseguro->cancelarAdesao($assinatura['pagseguro_adesao']);
                    if (!isset($xml->error)) {
                        $classAssinatura->update($assinatura['id'], array('status' => 2));
                        
                        $Resposta->insert('Assinatura cancelada com sucesso.', Resposta::SUCCESS);
                        die();
                    }
                    
                    $Resposta->insert('Erro ao cancelar assinatura', Resposta::ERROR);
                    $Resposta->setStatus(false);
                    die();
	            }
	            
	            $Resposta->insert('Cliente não possui assinatura ativa no pagseguro', Resposta::ERROR);
	            $Resposta->insert('Não necessita de cancelamento', Resposta::ERROR);
	            $Resposta->setStatus(false);
	            
                break;
		}			
	}

?>