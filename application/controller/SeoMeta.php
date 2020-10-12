<?php
	class SeoMeta extends Signoweb {
		public $orderby = "id ASC";
		public $tabela = 'seo_meta';
		
    public function dados($id){
	    	/*$sql = "SELECT * FROM seo_meta   where identificador = ".$id." ";
	    	$dadosRetorno = executaSql($this->conexao, $sql);
	    	ech
		    return $dadosRetorno;*/
        define( 'MYSQL_HOST', 'entendeu-direito.cmfcdkxvjyrt.sa-east-1.rds.amazonaws.com' );
        define( 'MYSQL_USER', 'admin' );
        define( 'MYSQL_PASSWORD', '1q2w3e4r' );
        define( 'MYSQL_DB_NAME', 'entendeudireitosite' );
        $PDO = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD );
	      $sql = "SELECT * FROM seo_meta where identificador = ".$id;
        $result = $PDO->query( $sql );
        $rows = $result->fetchAll();
      
        return $rows;
	  }
    
  
	}
?>