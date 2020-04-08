<?php
	class SeoMeta extends Signoweb {
		public $orderby = "id ASC";
		public $tabela = 'seo_meta';
		
    public function dados($id){
	    	/*$sql = "SELECT * FROM seo_meta   where identificador = ".$id." ";
	    	$dadosRetorno = executaSql($this->conexao, $sql);
	    	
		    return $dadosRetorno;*/
        define( 'MYSQL_HOST', 'localhost' );
        define( 'MYSQL_USER', 'edentend_site' );
        define( 'MYSQL_PASSWORD', 'site2019!' );
        define( 'MYSQL_DB_NAME', 'edentend_site' );
        $PDO = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD );
	      $sql = "SELECT * FROM seo_meta where identificador = ".$id;
        $result = $PDO->query( $sql );
        $rows = $result->fetchAll();
      
        return $rows;
	  }
    
  
	}
?>