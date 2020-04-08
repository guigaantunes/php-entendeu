<?php
	class Route {
		public $parametros;
		public $pagina;
		public $referencia;
		public $acao;
		public $usePageModel = true;
		
		public function __construct(){
			
			list($url, $query) = explode('?', $_SERVER['REQUEST_URI']);
			$url = str_ireplace(URL_ADMIN, '', $url);
			$this->parametros = explode("/", $url);	
			
			array_shift($this->parametros);
			
			list(, $this->pagina, $this->referencia, $this->acao) = $this->parametros;
			
			if (!$this->pagina)
				$this->pagina = 'cliente';
			
			if (!estaLogado()) {
				$this->pagina = 'login';
			}
			
			list($this->pagina, $tipo) = explode('.', $this->pagina);
			
			if (!$tipo)
				$tipo = 'html';
		}

		private function rsearch($folder, $pattern) {
		    $iti = new RecursiveDirectoryIterator($folder);
		    foreach(new RecursiveIteratorIterator($iti) as $file)
		        if(strpos($file , $pattern) !== false)
					return $file->getPathName();
			
		    return false;
		}
		
		public function includePage($page = false){
			if (!$page) {
				$page = $this->pagina;
			}
			
			$moduleFolder = $_SERVER['DOCUMENT_ROOT'].'/admin/public/modules';
            $filePath = $this->rsearch($moduleFolder, '/' . $page . '.php');
			
			if (!$filePath)
				$filePath = $this->rsearch($moduleFolder, '/404.php');
			
			include($filePath);
		}
	}
?>