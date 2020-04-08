<?php
    $class = new CategoriaBlog;
    
    
    $categorias = $class->getBy(
        $dados  = array(
            'status' => 1
        ),
        $campos = array('*'),
        $inner  = false,
        $left   = false,
        $groupBy= false,
        $having = false,
        $orderBy= 'ordem ASC'
    );
    
    //$url = $_SERVER['REQUEST_URI'];
    
?>
<div class="toggle-menu">
	<a class="title-menu">Procurar por categoria</a>	
	<div class="dropdown">
            <ul>
                <?foreach($categorias as $i => $categoria):?>
                    <li>
                       <a class="first-level" href="<?='/blog/categoria/'.$categoria['id']?>"><?=$categoria['titulo']?></a>
                    </li>
                <?endforeach;?>
            </ul>
      </div>

</div>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/toggle-menu.css" type="text/css" rel="stylesheet" media="screen"/>';
 	$scriptPage = '<script src="'.URL_SITE.'assets/js/components/toggle-menu.js"></script>';
?>