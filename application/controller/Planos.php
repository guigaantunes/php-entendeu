<?php 
	class Planos extends Signoweb {
        var $tabela = 'planos';

        public function getById_planos($id){
            $sql="select codigo from planos where id_plan= {$id}";
            
            $return =  $this->run($sql);
            return $return[0]["codigo"];
        }
        public function getPanByCupom($nome){
            $sql="select id_plan from planos where nome= '{$nome}' && status=1";
            return $this->run($sql);
        }
        public function getPlanbyIdentifier($plan){
            $sql="select vip from planos where codigo= '{$plan}' && status=1";
            $sql= $this->run($sql);
            if($sql[0]["vip"]==0){
                $var = 1;
            }
            else if($sql[0]["vip"]==1){
                $var=2;
            }
            else{
                $var=0;
            }
            return $var;
        }
    }
?>