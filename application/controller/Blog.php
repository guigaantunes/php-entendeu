<?php 
	class Blog extends Signoweb {
		var $tabela = 'blog';
		
		public function listar($id_categoria=FALSE) {
        	
        	$sql = '
        	    SELECT  blog.*,
        	            CONCAT("'.URL_SITE.'assets/dinamicos/blog/", blog.id, "/principal/", "p", arq.id, arq.arquivo) as image ,
        	            CONCAT("'.URL_SITE.'assets/dinamicos/blog/", blog.id, "/principal/", "g", arq.id, arq.arquivo) as image_lg ,
        	            u.nome as autor,
        	            DATE_FORMAT(blog.data_cadastro, "%M %d, %Y") AS data_formatada,
        	            categoria_blog.titulo AS categoria
                FROM    blog
                LEFT  JOIN  arquivo arq
                            ON arq.tabela = "blog" 
                            AND arq.tipo = "principal" 
                            AND arq.id_referencia = blog.id 
                LEFT  JOIN  categoria_blog
                            ON categoria_blog.id = blog.id_categoria 
                INNER JOIN  usuario u 
                            ON u.id = blog.id_usuario
                WHERE   blog.status = 1 '.($id_categoria ? "AND id_categoria=$id_categoria" : '').'
                ORDER BY id DESC';
                
            $retorno = $this->run($sql, array());
            return $retorno;    
                
		}
		
		public function getBySeletor($seletor) {
    		$sql = '
        	    SELECT  blog.*,
        	            CONCAT("'.URL_SITE.'assets/dinamicos/blog/", blog.id, "/principal/", "p", arq.id, arq.arquivo) as image ,
        	            CONCAT("'.URL_SITE.'assets/dinamicos/blog/", blog.id, "/principal/", "g", arq.id, arq.arquivo) as image_lg ,

        	            u.nome as autor,
        	            DATE_FORMAT(blog.data_cadastro, "%M %d, %Y") AS data_formatada 
                FROM    blog
                LEFT  JOIN  arquivo arq
                            ON arq.tabela = "blog" 
                            AND arq.tipo = "principal" 
                            AND arq.id_referencia = blog.id 
                INNER JOIN  usuario u 
                            ON u.id = blog.id_usuario
                WHERE   blog.status = 1 AND
                        blog.url    = "'.$seletor.'"
            ';
                
            $retorno = $this->run($sql, array());
            return end($retorno);
		}
		
		public function getAllById($id) {
    		$sql = '
        	    SELECT  blog.*,
        	            CONCAT("'.URL_SITE.'assets/dinamicos/blog/", blog.id, "/principal/", "p", arq.id, arq.arquivo) as image ,
        	            CONCAT("'.URL_SITE.'assets/dinamicos/blog/", blog.id, "/principal/", "g", arq.id, arq.arquivo) as image_lg ,

        	            u.nome as autor,
        	            DATE_FORMAT(blog.data_cadastro, "%M %d, %Y") AS data_formatada 
                FROM    blog
                LEFT  JOIN  arquivo arq
                            ON arq.tabela = "blog" 
                            AND arq.tipo = "principal" 
                            AND arq.id_referencia = blog.id 
                INNER JOIN  usuario u 
                            ON u.id = blog.id_usuario
                WHERE   blog.status = 1 AND
                        blog.id    = "'.$id.'"
            ';
                
            $retorno = $this->run($sql, array());
            return end($retorno);
		}
	}
?>