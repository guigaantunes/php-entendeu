<?php
	class Seo {
	
	public $id;
	public $orderBy;
	public $where;
	public $meta_title = SITE_TITLE;
	public $meta_tag = SITE_TITLE;
	public $meta_description = SITE_TITLE;
	public $conexao; // PDO Object

    public function __construct(){
        $this->conexao = conectar(SERVIDOR, BANCODEDADOS, USUARIO, SENHA);
    }

	function seo(){
		$sql = "SELECT * FROM configuracao WHERE id = 1 ";
		$dadosRetorno = executaSql($this->conexao, $sql);
		$this->meta_title = $dadosRetorno[0]["meta_title"];
		$this->meta_tag = $dadosRetorno[0]["meta_tag"];
		$this->meta_description = $dadosRetorno[0]["meta_description"];
	}

	public function dados(){
		$sql = "SELECT * FROM seo_meta WHERE (id=".$this->id.") ";
		$dadosRetorno = executaSql($this->conexao, $sql);
		return $dadosRetorno;
	}
	public function dadosBlog($titulo){
	    if($titulo){
	    	$sql = "SELECT * FROM seo_meta     ";
	    	$dadosRetorno = executaSql($this->conexao, $sql);
	    	foreach ($dadosRetorno as $value) {
                if( $value['meta_title']== $titulo){
                    $seo_tags= $value;
                }
            }
		    return $seo_tags;
	        
	    }
		else{
		    return false;
		}
	}
    public function metaTags($titulo){
	    if($titulo){
	    	$sql = 'SELECT * FROM seo_meta where meta_title = "'.$titulo.'"';
        //echo $sql;
	    	$dadosRetorno = executaSql($this->conexao, $sql);
	    	foreach ($dadosRetorno as $value) {
                if( $value['meta_title']== $titulo){
                    $seo_tags= $value;
                }
            }
		    return $seo_tags;
	        
	    }
		else{
		    return false;
		}
	}
    

	public function buscar($page, $identificador, $page_origem){
		if ($page != "" && $page != "principal") { 
			$sql = "SELECT * FROM seo_meta WHERE 1=1 ";
			if ($page == "conteudo") {
				$sql.= " AND identificador = '".$identificador."' ";
			} else {
				$sql.= " AND pagina = '".$page."' ";				
			}
			$sql.= " ORDER BY identificador";

			$dadosRetorno = executaSql($this->conexao, $sql);
			
			$regSEO = "";
			if (count($dadosRetorno) > 1) {
				# MAIS QUE UM, ANALISAR SE FOI PASSADO UM IDENTIFICADOR
				if ($identificador > 0) {
					$encontrado = false;
					foreach ($dadosRetorno as $valor) {
						if ($valor["identificador"] == $identificador) {
							$encontrado = true;
							$regSEO = $valor;
						}
						if ($encontrado) break;
					}
					if (!$encontrado) {
						# PASSAR O PRIMEIRO QUE RETORNAR E FOR PADRAO PARA ESSAS PAGINAS
						if ($dadosRetorno[0]["identificador"] == "0") {
							$regSEO = $dadosRetorno[0];
						# SENAO PASSAR O PADRAO DA PAGINA
						} else {
							$regSEO["meta_title"] = $this->meta_title;
							$regSEO["meta_tag"] = $this->meta_tag;
							$regSEO["meta_description"] = $this->meta_description;
						}
					}
				} else {
					# PASSAR O PRIMEIRO QUE RETORNAR E FOR PADRAO PARA ESSAS PAGINAS
					if ($dadosRetorno[0]["identificador"] == "0") {
						$regSEO = $dadosRetorno[0];
					# SENAO PASSAR O PADRAO DA PAGINA
					} else {
						$regSEO["meta_title"] = $this->meta_title;
						$regSEO["meta_tag"] = $this->meta_tag;
						$regSEO["meta_description"] = $this->meta_description;
					}
				}
			} elseif (count($dadosRetorno) == 1) {
				# VERIFICAR SE BATE COM ALGUM IDENTIFICADOR OU SE É REGISTRO PADRAO SEM IDENTIFICADOR
				if ($dadosRetorno[0]["identificador"] == "0" || $dadosRetorno[0]["identificador"] == $identificador) {
					$regSEO = $dadosRetorno[0];	
				} else {
					# PEGA O PADRAO
					$regSEO["meta_title"] = $this->meta_title;
					$regSEO["meta_tag"] = $this->meta_tag;
					$regSEO["meta_description"] = $this->meta_description;	
				}
				
			} else {
				# NADA ENCONTRADO, RETORNAR VALORES PADRAO DO SITE
				$sql = "SELECT * FROM seo_meta WHERE 1=1 ";
				if ($page_origem != "")
					$sql.= " AND pagina = '".$page_origem."' ORDER BY identificador";
				$dadosRetorno = executaSql($this->conexao, $sql);
				if (count($dadosRetorno) > 0) {
					$regSEO = $dadosRetorno[0];
				} else {
					$regSEO["meta_title"] = $this->meta_title;
					$regSEO["meta_tag"] = $this->meta_tag;
					$regSEO["meta_description"] = $this->meta_description;
					
				}
			}
		} else {
		
			if ($page == "principal") {
				$sql = "SELECT * FROM seo_meta WHERE 1=1 ";
				$sql.= " AND pagina = '".$page."' ";				
				$sql.= "ORDER BY identificador";
				$dadosRetorno = executaSql($this->conexao, $sql);
				$regSEO = "";
				if (count($dadosRetorno) > 0) {
					$regSEO = $dadosRetorno[0];
				} else {
					$regSEO["meta_title"] = $this->meta_title;
					$regSEO["meta_tag"] = $this->meta_tag;
					$regSEO["meta_description"] = $this->meta_description;					
				}
			} else {
				$regSEO["meta_title"] = $this->meta_title;
				$regSEO["meta_tag"] = $this->meta_tag;
				$regSEO["meta_description"] = $this->meta_description;
			}
		}
		return $regSEO;
	}

	public function urlRedirecionar($parametros, $indice){
		# MONTANDO URL COMPLETA COM TODOS OS PARAMETROS SUBSEQUENTES
		$url_completa = "";
		$parametros_str = "";
		for ($count=0; $count <= (count($parametros)-1); $count++) {
			//echo $count."->".$parametros[$count]."<br>";
			$parametros_str.= ($count > 0 ? "/" : "").$parametros[$count];
			if ($count >= $indice) {
				$url_completa.= ($count > $indice ? "/" : "").$parametros[$count];
			}
		}
		$url = $parametros[$indice];
		
		if ($url == "conteudo" || $url == "produto" || $url == "galeria") {
			return $parametros;
		}

		# VALIDACOES
		$sql = "SELECT * FROM seo_url ";
		if ($url_completa != "")
			$sql.= " WHERE origem = '".$url_completa."' ORDER BY id";
		#echo $sql;	
		$dadosRetorno = executaSql($this->conexao, $sql);
		#var_dump($sql, $dadosRetorno);
		if (count($dadosRetorno) > 0 AND is_array($dadosRetorno)) {
			$parametros_str = "/".str_replace($dadosRetorno[0]["origem"], $dadosRetorno[0]["destino"], $parametros_str);
			$parametros = explode("/",$parametros_str);	
			array_shift($parametros);		
			return $parametros;
		} else {
			$sql = "SELECT * FROM seo_url ";
			if ($url != "")
				$sql.= " WHERE origem = '".$url."' ORDER BY id";
			# echo $sql;
			$dadosRetorno = executaSql($this->conexao, $sql);
			#var_dump($sql, $dadosRetorno);
			if (count($dadosRetorno) > 0 AND is_array($dadosRetorno)) {
				$parametros_str = "/".str_replace($dadosRetorno[0]["origem"], $dadosRetorno[0]["destino"], $parametros_str);
				$parametros = explode("/",$parametros_str);	
				array_shift($parametros);	
				return $parametros;
			} 
		} 
		
		# ANTES DE RETORNAR VERIFICAR INVERSO
		$sql = "SELECT * FROM seo_url ";
		if ($url != "")
			$sql.= " WHERE destino = '".$url_completa."' ORDER BY id";
			#echo $sql;	
		$dadosRetorno = executaSql($this->conexao, $sql);
		#var_dump($sql, $dadosRetorno);
		if (count($dadosRetorno) > 0 AND is_array($dadosRetorno)) {
			//echo "debug 0";
			$dest = explode("/",$dadosRetorno[0]["origem"]);	
			//echo $dest[0];
			
			$parametros_str = "/".str_replace($dadosRetorno[0]["destino"], $dadosRetorno[0]["origem"], $parametros_str);
			$parametros = explode("/",$parametros_str);	
			//print_r($parametros);
			array_shift($parametros);	
			return $parametros;
		} 
		
		return $parametros;
	}
	
	public function urlSEO($url, $url_completa, $id, $nome){		
		# VALIDACOES
		$sql = "SELECT * FROM seo_url WHERE 1=1 ";
		if ($url_completa != "")
			$sql.= " AND origem = '".$url_completa."' ORDER BY id";
		$dadosRetorno = executaSql($this->conexao, $sql);
		if (count($dadosRetorno) > 0) {
			return $dadosRetorno[0]["destino"];
		} else {
			$sql = "SELECT * FROM seo_url WHERE 1=1 ";
			if ($url != "")
				$sql.= " AND origem = '".$url."' ORDER BY id";
			$dadosRetorno = executaSql($this->conexao, $sql);
			if (count($dadosRetorno) > 0) {
				return $dadosRetorno[0]["destino"]."/".$id."/".$nome;
			} 
		}	
		return $url_completa; 
	}
	
	public function urlSEOFixa($url){
		# VALIDACOES
		$sql = "SELECT * FROM seo_url WHERE ";
		$sql.= " origem = '".$url."' ORDER BY id";
		$dadosRetorno = executaSql($this->conexao, $sql);
		if (count($dadosRetorno) > 0) {
			return '/'.$dadosRetorno[0]["destino"];
		}
		return URL_SITE.$url; 
	}
}	

?>