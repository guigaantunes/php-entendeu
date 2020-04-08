<?php 
	class Arquivo extends Signoweb {
		var $tabela = 'arquivo';
		
		/**
		 * Faz o upload da imagem e salva no banco de dados
		 *
		 * @param array $file = $_FILES['nomeDoInput']
		 * @param string $tabela Nome da tabela no banco
		 * @param numeric $idReferencia Id do registro na tabela acima a quem essa imagem pertence
		 * @param string $tipo = [perfil, background, capa, apresentacao...]
		 */
		public function upload($file, $tabela, $idReferencia, $tipo = '', $returnId = false) {
			$file['name'] = strtolower($file['name']);
			
			$Uploader = new Upload($file);
			$fileName = date("dmY_H_i_s");
			
			$explodir = explode(".", $file["name"]);
			$extensao = end($explodir);
			
			global $IMAGENS;
			$parametros = $IMAGENS[$tabela][$tipo]['tamanhos'];
			
			$success = $Uploader->uploaded;
			
			if (!$success) {
				throw new FileUploadException('Erro do Uploader: '.$Uploader->error);
			}
			
			$folder = "{$tabela}/{$idReferencia}/";
			
			$imagem['arquivo'] = $fileName.'.'.$extensao;
			$imagem['tipo'] = $tipo;
			$imagem['tabela'] = $tabela;
			$imagem['id_referencia'] = $idReferencia;
			
			$idImagem = $this->insert($imagem);
			
			if ($idImagem < 1 OR !is_numeric($idImagem)) {
				throw new FileUploadException('Erro ao registrar no banco');
			}
				
			if (is_null($Uploader)) return false;
			
			$imagem['id'] = $idImagem;
			$imagem['url'] = URL_SITE . "assets/dinamicos/$tabela/$idReferencia/$tipo/";
			$this->imagem = $imagem;
			
			$path = PATH_ABSOLUTO . "assets/dinamicos/$tabela/$idReferencia/$tipo/";
			$nome = $idImagem . $fileName;
			
			
			if (empty($parametros)) {
				$Uploader->file_new_name_body = $nome;
				$Uploader->process($path);
			} else foreach ($parametros as $prefixo => $parametro) {
				if ($prefixo === 'null') $prefixo = '';
				$Uploader->file_new_name_body = $prefixo.$nome;
				
				foreach ($parametro as $dado => $valor) {
					$Uploader->$dado = $valor;
				}
				$Uploader->process($path);
			}
			
			if (!$Uploader->processed) {
				throw new FileUploadException('Erro do Uploader: '.$Uploader->error);
			}
			
			if($returnId)
				return $idImagem;
				
			return true;
		}
		
		public function deleteById($id){
			$conexao = new Connection;
			list($arquivo) = $this->getBy(array('id' => $id));
			$success = $conexao->run('DELETE FROM ' . $this->tabela . ' WHERE id = ?', array($id), 'd');
			
			if (!$success)
				return false;
			
			$path = PATH_ABSOLUTO . "assets/dinamicos/{$arquivo['tabela']}/{$arquivo['id_referencia']}/{$arquivo['tipo']}/";
			$nome = $arquivo['id'] . $arquivo['arquivo'];
			
			global $IMAGENS;
			$parametros = $IMAGENS[$arquivo['tabela']][$arquivo['tipo']]['tamanhos'];
			
			if (empty($parametros)) {
				$success = @unlink($path . $nome);
				if (!$success) {
					debug_log('FALHA AO APAGAR ARQUIVO:', $path . $nome);
				}
			} else foreach ($parametros as $prefixo => $parametro) {
				if ($prefixo === 'null') 
					$prefixo = '';
				
				$success = @unlink($path . $prefixo . $nome);
				if (!$success) {
					debug_log('FALHA AO APAGAR ARQUIVO:', $path . $prefixo . $nome);
				}
			}
			
			return true;
		}
	}
	
	class FileUploadException extends Exception {}
?>