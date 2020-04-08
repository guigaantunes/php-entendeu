<?php

	class Modulos {
		
		public $conexao; // PDO Object
		public $modulos;

	    public function __construct($id){
		    
	        $this->conexao = conectar(SERVIDOR, BANCODEDADOS, USUARIO, SENHA);
	        
			$modulos = $this->listar();						
				
			foreach($modulos as $i => $modulo){
				
				if(in_array($modulo["id"], $_SESSION["modulos"])){				
										
				// 	@ Verificação para ver se o módulo tem submodulo e mostrar o módulo principal no menu caso tenha apenas o submódulo
										
					if($id_modulo = $this->isSubModulo($modulo["id"])){
						
						if(!in_array($id_modulo, $_SESSION["modulos"])){
							
							$campos = array("id");
							$valores = array($id_modulo);
							
							$modulosPermitidos[] = arrayToUTF_8(end(registro($this->conexao, 'modulos', $campos, $valores)));
						}	
						
					} else {
						
						$modulosPermitidos[] = $modulo;	
					}
					
				}
				
			}
			
			$this->modulos = arrayToFunction("utf8_decode", multiArrayToUTF_8($modulosPermitidos));		        
	        
	    }
	    
		public function listar(){
			
			$modulos = executaSql($this->conexao, "SELECT * FROM modulos ORDER BY id ASC");
			
			return multiArrayToUTF_8($modulos);		
		}
	    
	    public function isSubModulo($id_modulo){
		    
		    $sub_modulos = end(executaSql($this->conexao, "SELECT * FROM sub_modulos WHERE id_sub_modulo = ".$id_modulo));
		    
		    return $sub_modulos["id_modulo"];
		    
	    }
	    
	    public function modulePage($page){		    
		    foreach($this->modulos as $i => $modulo){
			    if($modulo["url"] == $page){
				    return $i + 1; // ajusta índice 0
			    }
		    }		    
	    }
	    
	    public function hasPermission($page){		    
		    
		    foreach($this->modulos as $i => $modulo){
			    if($modulo["url"] == $page){
				    return true;
			    }
		    }
		    
		    return false; 
	    }
	    
	    public function hasModule($id){
		    
		    foreach($_SESSION["modulos"] as $i => $id_modulo){
			    if($id_modulo == $id){
				    return true;
			    }
		    }
		    
		    return false; 		    
	    }
		
	}
	
?>