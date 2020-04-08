<?php 
	class Banner extends Signoweb {
		var $tabela = 'banner';
		
		public function listar() {
        	
        	$sql = '
        	    SELECT  banner.*,
        	            CONCAT("'.URL_SITE.'assets/dinamicos/banner/", banner.id, "/banner/", "p", arq.id, arq.arquivo) as url, 
                        CONCAT("'.URL_SITE.'assets/dinamicos/banner/", banner.id, "/banner_mob/", "p", arq2.id, arq2.arquivo) as url_mobile 
                FROM    banner
                INNER JOIN  arquivo arq
                            ON arq.tabela = "banner" 
                            AND arq.tipo = "banner" 
                            AND arq.id_referencia = banner.id
                INNER JOIN  arquivo arq2
                            ON arq2.tabela = "banner" 
                            AND arq2.tipo = "banner_mob" 
                            AND arq2.id_referencia = banner.id 
                WHERE   banner.status = 1
                ORDER BY ordem asc'            ;
                
            $banners = $this->run($sql, array());
            return $banners;    
                
		}
	}
?>