<?php
	require_once("classes/class.seo.php");
	class Route {
				
		public $parametros;
		public $pagina;
		public $id = false;
		public $subid = false;
		public $classes;
		
		public $idTopico;
		
		public function __construct(){
    		session_start();
			$this->conexao = conectar(SERVIDOR, BANCODEDADOS, USUARIO, SENHA);
			$this->parametros = explode("/", str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]));	
			
			array_shift($this->parametros);
			$params = $this->parametros;
									
			if (!$this->parametros[0]) {
				$this->pagina = 'principal';
			} else {	
				$this->pagina = $this->parametros[0];
			}	
		
			
			//unset($_SESSION["paginas"]);
			# GUARDAR HISTORICO DA NAVEGACAO NOS TOPICOS
			/*
			if ($this->pagina == "topico") {
				$_SESSION["paginas"][] = substr($_SERVER["REQUEST_URI"], 1);
				$_SESSION["paginas"]["atual"] = substr($_SERVER["REQUEST_URI"], 1);
			}
			# MARCAR EM UMA VARIAVEL DE SECAO A PAGINA ANTERIOR
			if (count($_SESSION["paginas"]) > 0) {
				$historiconavegacao = $_SESSION["paginas"];
				foreach($historiconavegacao as $paginaHistorico) {
					if ($paginaHistorico != $_SESSION["paginas"]["atual"])	{
						$_SESSION["paginas"]["voltar"] = $paginaHistorico;
					}
				}
			}
			*/
			if ($this->pagina == "topico") {
				$this->idTopico["topico"] = $this->parametros[1]; # id do topico
				$this->idTopico["materia"] = $this->parametros[2]; # id do materia
				$this->idTopico["disciplina"] = $this->parametros[3]; # id do disciplica
			}
						
			# CLASSES - INSTANCIAR
			$seo = new Seo();
			$this->classes["seo"] = $seo;	
			
			//print_r($this->parametros);
			
			$indice = "0";
			if ($this->parametros[$indice] == "" || $this->parametros[$indice] == "index.php") {
				$page = "principal";
			} else {
				$page_origem = $this->parametros[$indice];
				//print_r($this->parametros);
				$this->parametros = $seo->urlRedirecionar($this->parametros, $indice); 
				//print_r($this->parametros);
				if (!$this->parametros[0]) {
					$this->pagina = 'principal';
				} else {
					$this->pagina = $this->parametros[0];
					if ($this->parametros[0] == "ajax") {
						$this->requisicaoAjax = true;
						$this->pagina = $this->parametros[1];
					}
				}
				$page =	$this->parametros[$indice];
			}

			
			$id = $this->parametros[($indice+1)];

			$this->id = $this->parametros[($indice+1)];
			$this->regSEO = $seo->buscar($page, $id, $page_origem);
			
			$this->regSEO['parametros'] = $params;
			
		}

		public function includeMetas() {
			$regSEO = $this->regSEO;
			$seo = new Seo();
			
			
			/*
			$html = '<title>'.($regSEO["meta_title"] ? $regSEO["meta_title"] : NOME_EMPRESA).'</title>
			<meta property="og:title" content="'.($regSEO["meta_title"] ? $regSEO["meta_title"] : NOME_EMPRESA).'">
			<meta property="og:site_name" content="'.NOME_EMPRESA.'">
			<meta property="description" content="'.$regSEO["meta_description"].'"/>
			<meta property="og:description" content="'.$regSEO["meta_description"].'"/>
			<meta property="og:url" content="' . URL_SITE . implode('/', $this->regSEO['parametros']) . '">';
			*/
			if ($this->pagina == 'principal') {
				$html = 
    					'<title>'.NOME_EMPRESA.'</title>
    					<meta property="og:title" content="'.NOME_EMPRESA.'">
    					<meta property="og:site_name" content="'.NOME_EMPRESA.'">
    					<meta property="description" content="'.NOME_EMPRESA.'"/>
    					<meta property="og:description" content="'.NOME_EMPRESA.'"/>
    					<meta property="og:url" content="' . URL_SITE . implode('/', $this->regSEO['parametros']) . '">
    					
                        <meta property="og:title" content="'.NOME_EMPRESA.'">
                        <meta property="og:description" content="Traduzindo o direito para todo mundo com associações neurolinguísticas."/>
                        <meta property="og:url" content="'. URL_SITE .'">
                        <meta property="og:site_name" content="'.NOME_EMPRESA.'"/>
                        <meta property="og:type" content="'.URL_SITE.'">
                        <meta property="og:image" content="'.URL_ADMIN.images/logo.png.'">
                        
                        <meta name="twitter:title" content="'.NOME_EMPRESA.'">
                        <meta name="twitter:description" content="Traduzindo o direito para todo mundo com associações neurolinguísticas.">
                        <meta name="twitter:url" content="'. URL_SITE .'">
                        <meta name="twitter:image" content="'.URL_ADMIN.images/logo.png.'">
                        <meta name="twitter:site" content="@entendeudireito">';
			}
			else if($this->pagina == 'conteudo'){
			    $titulo = explode('-',$this->parametros[1]);
			    foreach($titulo as $t =>$i){
			        if($t==0){
			            $permtitulo .= ucfirst($i);
			        }else{
			            $permtitulo .= " ".ucfirst($i);
			        }
			        
			        
			        
			    }
        //var_dump($permtitulo);

			    $tags_singlepost = $seo->metaTags($permtitulo);
			    //var_dump ($tags_singlepost) ;
			    /*
			    array(8) {
                  ["id"]=>
                  int(5)
                  ["pagina"]=>
                  string(8) "conteudo"
                  ["identificador"]=>
                  int(76)
                  ["meta_title"]=>
                  string(27) "Direitos Humanos - Conceito"
                  ["meta_tag"]=>
                  string(41) "direitos,humanos,direitos humanos,direito"
                  ["meta_description"]=>
                  string(264) "“Os Direitos Humanos não foram conquistados e reconhecidos de uma só vez, havendo uma luta pela sua efetivação. - Assim, os Direitos Fundamentais do Homem passaram do individual, ao coletivo e deste à categoria de direitos de solidariedade.” (Bobbio) A de"
                  ["data_cadastro"]=>
                  string(19) "2019-10-04 17:44:59"
                  ["status"]=>
                  int(1)
                }*/
			     
			    $html = 
			            '<title>'.$tags_singlepost['meta_title'].'</title>
                		<meta property="og:title" content="'.$tags_singlepost['meta_title'].'">
        				<meta property="og:site_name" content="'.NOME_EMPRESA.'">
    					<meta property="og:description" content="'.$tags_singlepost['meta_description'].'"/>
    					<meta property="og:url" content="' . URL_SITE . implode('/', $this->regSEO['parametros']) . '">
    					<meta property="keywords" content="' .$tags_singlepost['meta_tag'] . '">
                        <meta property="og:type" content="'.URL_SITE.'">
                        <meta property="og:image" content="https://www.entendeudireito.com.br'.$_SERVER["REQUEST_URI"].'img.jpg">
                        
                        <meta name="twitter:title" content="'.NOME_EMPRESA.'">
                        <meta name="twitter:description" content="'.$tags_singlepost['meta_description'].'">
                        <meta name="twitter:url" content="'. URL_SITE .'">
                        <meta name="twitter:image" content="https://www.entendeudireito.com.br'.$_SERVER["REQUEST_URI"].'img.jpg">
                        <meta name="twitter:site" content="@entendeudireito">';
			}
			else if($this->pagina == 'single-post'){
			    $titulo = explode('-',$this->parametros[4]);
			   // var_dump($titulo);
			    foreach($titulo as $t =>$i){
			        if($t==0){
			            $permtitulo .= ucfirst($i);
			        }else{
			            $permtitulo .= " ".ucfirst($i);
			        }
			        
			        
			        
			    }
			    $titulo=strtoupper($permtitulo);
			    //echo $titulo;
			    $tags_singlepost = $seo->dadosBlog($titulo);
			    //var_dump ($tags_singlepost) ;
			    /*
			    array(8) {
                  ["id"]=>
                  int(5)
                  ["pagina"]=>
                  string(8) "conteudo"
                  ["identificador"]=>
                  int(76)
                  ["meta_title"]=>
                  string(27) "Direitos Humanos - Conceito"
                  ["meta_tag"]=>
                  string(41) "direitos,humanos,direitos humanos,direito"
                  ["meta_description"]=>
                  string(264) "“Os Direitos Humanos não foram conquistados e reconhecidos de uma só vez, havendo uma luta pela sua efetivação. - Assim, os Direitos Fundamentais do Homem passaram do individual, ao coletivo e deste à categoria de direitos de solidariedade.” (Bobbio) A de"
                  ["data_cadastro"]=>
                  string(19) "2019-10-04 17:44:59"
                  ["status"]=>
                  int(1)
                }*/
			     
			    $html = 
			            '<title>'.$tags_singlepost['meta_title'].'</title>
                		<meta property="og:title" content="'.$tags_singlepost['meta_title'].'">
        				<meta property="og:site_name" content="'.NOME_EMPRESA.'">
    					<meta property="og:description" content="'.$tags_singlepost['meta_description'].'"/>
    					<meta property="og:url" content="' . URL_SITE . implode('/', $this->regSEO['parametros']) . '">
    					<meta property="keywords" content="' .$tags_singlepost['meta_tag'] . '">
                        <meta property="og:type" content="'.URL_SITE.'">
                        <meta property="og:image" content="https://www.entendeudireito.com.br'.$_SERVER["REQUEST_URI"].'img.jpg">
                        
                        <meta name="twitter:title" content="'.NOME_EMPRESA.'">
                        <meta name="twitter:description" content="'.$tags_singlepost['meta_description'].'">
                        <meta name="twitter:url" content="'. URL_SITE .'">
                        <meta name="twitter:image" content="https://www.entendeudireito.com.br'.$_SERVER["REQUEST_URI"].'img.jpg">
                        <meta name="twitter:site" content="@entendeudireito">';
			}
			elseif($this->pagina == 'topico'){
			     $titulo = explode('-',$this->parametros[4]);
			   // var_dump($titulo);
			    foreach($titulo as $t =>$i){
			        if($t==0){
			            $permtitulo .= ucfirst($i);
			        }else{
			            $permtitulo .= " ".ucfirst($i);
			        }
			        
			        
			        
			    }
			    
			     
			    $html = 
			            '<title>'.$permtitulo.'</title>
                		<meta property="og:title" content="'.$permtitulo.'">
        				<meta property="og:site_name" content="'.NOME_EMPRESA.'">
        				<meta property="description" content="'.NOME_EMPRESA.'"/>
    					<meta property="og:description" content="'.NOME_EMPRESA.'"/>
    					<meta property="og:url" content="' . URL_SITE . implode('/', $this->regSEO['parametros']) . '">
    					
                        <meta property="og:title" content="'.NOME_EMPRESA.'">
                        <meta property="og:description" content="Traduzindo o direito para todo mundo com associações neurolinguísticas."/>
                        <meta property="og:url" content="'. URL_SITE .'">
                        <meta property="og:site_name" content="'.NOME_EMPRESA.'"/>
                        <meta property="og:type" content="'.URL_SITE.'">
                        <meta property="og:image" content="'.URL_ADMIN.images/logo.png.'">
                        
                        <meta name="twitter:title" content="'.NOME_EMPRESA.'">
                        <meta name="twitter:description" content="Descrição da página em menos de 200 caracteres.">
                        <meta name="twitter:url" content="'. URL_SITE .'">
                        <meta name="twitter:image" content="'.URL_ADMIN.images/logo.png.'">
                        <meta name="twitter:site" content="@entendeudireito">';
			}
			else{
			    $html = 
			            '<title>'.ucfirst($this->pagina).'</title>
                		<meta property="og:title" content="'.ucfirst($this->pagina).'">
        				<meta property="og:site_name" content="'.NOME_EMPRESA.'">
        				<meta property="description" content="'.NOME_EMPRESA.'"/>
    					<meta property="og:description" content="'.NOME_EMPRESA.'"/>
    					<meta property="og:url" content="' . URL_SITE . implode('/', $this->regSEO['parametros']) . '">
    					
                        <meta property="og:title" content="'.NOME_EMPRESA.'">
                        <meta property="og:description" content="Traduzindo o direito para todo mundo com associações neurolinguísticas."/>
                        <meta property="og:url" content="'. URL_SITE .'">
                        <meta property="og:site_name" content="'.NOME_EMPRESA.'"/>
                        <meta property="og:type" content="'.URL_SITE.'">
                        <meta property="og:image" content="'.URL_ADMIN.images/logo.png.'">
                        
                        <meta name="twitter:title" content="'.NOME_EMPRESA.'">
                        <meta name="twitter:description" content="Descrição da página em menos de 200 caracteres.">
                        <meta name="twitter:url" content="'. URL_SITE .'">
                        <meta name="twitter:image" content="'.URL_ADMIN.images/logo.png.'">
                        <meta name="twitter:site" content="@entendeudireito">';
			}
						
			echo $html; 
		}
		
		public function includePage(){
			$conexao = conectar();
			
// 			$mapDiretorio = "";
			$dir = new DirectoryIterator(PATH_ABSOLUTO.'application/views');
			foreach($dir as $file ){
				if (!$file->isDot() && $file->isDir()) {
			    	$mapDiretorio[] = $file->getFilename();
			 	}
			}

			if (count($mapDiretorio) > 0)
			foreach($mapDiretorio as $diretorio) {
				$dir = new DirectoryIterator( PATH_ABSOLUTO.'application/views/'.$diretorio);
				foreach($dir as $file ){
					if (!$file->isDot() && $file->isDir()) {
				    	$mapDiretorio[] = $diretorio."/".$file->getFilename();
				 	}
				}
			}
			
			$isEncontrado = false;
			if (count($mapDiretorio) > 0)
			foreach($mapDiretorio as $diretorio) {
				
				if (file_exists(PATH_ABSOLUTO."application/views/".$diretorio."/".$this->pagina.".php")) {
					include (PATH_ABSOLUTO."application/views/".$diretorio."/".$this->pagina.".php");
					$isEncontrado = true;
					//break;
				}
			}
			
			if ($isEncontrado == false) {
				if (file_exists(PATH_ABSOLUTO."application/views/".$this->pagina.".php")) {
					include (PATH_ABSOLUTO."application/views/".$this->pagina.".php"); 
				} else {
					include (PATH_ABSOLUTO."application/views/404.php"); 
				}
			}
		}
		
	}
?>