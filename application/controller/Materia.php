<?php 
	class Materia extends Signoweb {
		var $tabela = 'materia';
		
	    public function nextOrder($idDisciplina) {
    	    $ordem = $this->getBy(
        	    $dados = array(
            	    'status' => 1,
            	    'id_disciplina' => $idDisciplina
        	    ),
        	    $campos = array(
            	    "MAX(ordem) as ordem",
        	    )
    	    );
    	    
    	    if( $ordem == FALSE) $ordem = -1;    	
    	    if( end($ordem)['ordem'] === FALSE || end($ordem)['ordem'] === NULL) $ordem = -1;
    	    if( is_numeric(end($ordem)['ordem']) ) $ordem = end($ordem)['ordem'];
    	    

    	    return $ordem + 1;
		}
		public function getTitulos($palavra){
			$sql = "
				SELECT * 
				FROM materia 
				WHERE titulo 
				LIKE '%".$palavra."%' && 
				status = 1 &&
				id_disciplina = 1
			"	;
    	    
            return $this->run($sql, array());
		}
		public function materialDemonstrativo($id){
			$sql = "
				SELECT * 
				FROM materialestudo 
				WHERE id_materia = $id && 
				status = 1 &&
				demonstrativo = 1
			"	;
    	    
            return $this->run($sql, array());
		}
	}
?>