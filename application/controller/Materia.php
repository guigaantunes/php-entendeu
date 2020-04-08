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
	}
?>