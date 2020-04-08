<?php 
	class ClienteLeuMaterial extends Signoweb {
		var $tabela = 'cliente_leu_material';
		
/*
		public function assinaturaCliente($idCliente, $idMaterialEstudo) {
    		return $this->getBy(
        		array(
            		'status'            => 1,
            		'id_cliente'        => $idCliente,
            		'id_materialestudo' => $idMaterialEstudo
        		)
    		);
		}
*/

        public function materialLido($id_material, $id_cliente=false) {
            
            if (!isset($_SESSION['cliente']['id']))
                return false;
                
            $id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);
            
            $sql = "
                SELECT  * 
                FROM    {$this->tabela} 
                WHERE   id_cliente          = {$id_cliente}     AND 
                        id_materialestudo   = {$id_material}    AND 
                        status = 1
            ";
            
            $retorno = $this->run($sql, array());
            $retorno = end($retorno);
            
            return !!$retorno;
        }
        
        public function materiaLida($id_materia, $id_cliente=false) {
            //lista todas os materiais da matéria
            $classMaterialEstudo = new MaterialEstudo;
            
            $materiais = $classMaterialEstudo->getBy(
                array(
                    'status'    => 1,
                    'id_materia'=> $id_materia
                )
            );
            
            foreach($materiais as $i => $material) {
                if ( !$this->materialLido($material['id'], $id_cliente) )
                    return false;
            }
            
            return true;
        }
        
        public function DisciplinaLida($id_disciplina, $id_cliente=false) {
            //lista todas os matérias da disciplina
            $classMateria = new Materia;
            
            $materias = $classMateria->getBy(
                array(
                    'status'        => 1,
                    'id_disciplina' => $id_disciplina       
                )
            );
            
            
            foreach($materias as $i => $materia) {
                if ( !$this->materiaLida($materia['id'], $id_cliente) )
                    return false;
            }
            
            return true;
            
        }
        
        public function alterarStatus($id_material, $status, $id_cliente=false) {
            
            if (!isset($_SESSION['cliente']['id']))
                return false;
                
            $id_cliente = ($id_cliente ? $id_cliente : $_SESSION['cliente']['id']);

            
            $existe = $this->getBy(
                array(
                    'id_cliente'            => $id_cliente,
                    'id_materialestudo'     => $id_material
                )
            );
            $existe = end($existe);
            
            if ($existe) {
                $success = $this->update($existe['id'], array('status' => $status));
            } else {
                if ($status) {
                    $success = $this->insert(array('id_cliente' => $id_cliente, 'id_materialestudo' => $id_material));
                    $success = is_numeric($success);
                } else {
                    $success = true;
                }
            }
            
            return $success;
        }
		
		
		
	}
?>