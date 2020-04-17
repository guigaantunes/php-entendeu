<?php 
	require_once( "/var/www/html/config.php");
	class MaterialEstudo extends Signoweb {
		var $tabela = 'materialestudo';
		
		public function getFiles($id) {
    	    $sql = "
    	        SELECT  arquivo.id,
    	                CONCAT('".URL_SITE."assets/dinamicos/materialestudo/', id_referencia, '/arquivo/', id, arquivo) as arquivo
    	        FROM    arquivo 
    	        WHERE   tabela          = '{$this->tabela}' AND 
    	                id_referencia   = {$id}             AND
    	                tipo            = 'arquivo'         
    	    "	;
			
            return $this->run($sql, array());
		}
		
		public function getImages($id) {
    	    $sql = "
    	        SELECT  CONCAT('".URL_SITE."assets/dinamicos/materialestudo/', id_referencia, '/principal/p', id, arquivo) as p,
    	                CONCAT('".URL_SITE."assets/dinamicos/materialestudo/', id_referencia, '/principal/g', id, arquivo) as g
    	        FROM    arquivo 
    	        WHERE   tabela          = '{$this->tabela}' AND 
    	                id_referencia   = {$id}             AND
    	                tipo            = 'principal'      
    	        ORDER BY id ASC   
    	    "	;
    	    
            return $this->run($sql, array());
		}
		public function getTitulos($texto){
			$sql = "
				SELECT * 
				FROM materialestudo 
				WHERE titulo LIKE '%".$texto."%'
				&& status = 1
			"	;
    	    
            return $this->run($sql, array());
		}
		
		public function ajustarOrdem($id, $ordem, $materia) {
			$sql = "select * from materialestudo where id_materia = ".$materia." AND ordem = ".$ordem." AND id <> ".$id;
			$dados = $this->run($sql, array());
			foreach ($dados as $indice => $reg) {
				$atualiza["ordem"] = (int)$reg["ordem"]+1;
				$this->update($reg["id"], $atualiza, false);
			}
			
			$sql = "select * from materialestudo where id_materia = ".$materia." ORDER BY ordem ASC, titulo ASC, id ASC ";
			$dados = $this->run($sql, array());
			foreach ($dados as $indice => $reg) {
				$atualiza["ordem"] = $indice;
				$this->update($reg["id"], $atualiza, false);
			}
            return "";
		}
		
	}
?>