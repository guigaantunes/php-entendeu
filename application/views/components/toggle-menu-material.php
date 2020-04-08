<?php
    $classMaterialEstudo= new MaterialEstudo;
    $classDisciplina    = new Disciplina;   
    $classMateria       = new Materia;
    $classLeu           = new ClienteLeuMaterial;
//     $classTopico        = new Topico;
    
    
    $disciplinas = $classDisciplina->getBy(
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
	$busca = $_GET['busca']; 
	//echo "<pre>".print_r($this->idTopico, true);
?>

<div class="search-items">
	<input type="text" placeholder="Buscar..." class="search small-space" value="<?=$busca?>"/>
	<i class="icon-search search-topico"></i> 
</div>

<div class="toggle-menu">
	<a class="title-menu">Direito Administrativo</a>	
	<div class="dropdown">
            <ul class="lista-menu">
                <?foreach($disciplinas as $i => $disciplina):?>
                    <li class="item-first-level" data-id="<?=$disciplina['id']?>">
                        <a class="first-level" href="javascript:void(0)"><?=$disciplina['titulo']?>
                        	<i class="icon-arrow btn-icon"></i>
                        </a>
                        <ul class="second-level">
                            <?php
                                $materias = $classMateria->getBy(
                                    $dados  = array(
                                        'status' => 1,
                                        'id_disciplina' => $disciplina['id']
                                    ),
                                    $campos = array('*'),
                                    $inner  = false,
                                    $left   = false,
                                    $groupBy= false,
                                    $having = false,
                                    $orderBy= 'ordem ASC'
                                );
                                
                                foreach($materias as $j => $materia):
                            ?>
                            
                                <li class="item-second-level" data-id="<?=$materia['id']?>"><a class="option-second-level" href="javascript:void(0)"><?=$materia['titulo']?></a>
                                	<ul class="third-level" href="javascript:void(0)"> 
                                    	<?php
                                            $materiais2 = $classMaterialEstudo->getBy(
                                                $dados  = array(
                                                    'materialestudo.status' => 1,
                                                    'materialestudo.id_materia' => $materia['id']
                                                ),
                                                $campos = array(
                                                	'materialestudo.*',
                                                	'seo_url.destino as destino'
                                                ),
                                                $inner  = false,
                                                $left   = array(
									                'seo_url' => array(
										                "CONCAT('topico/', materialestudo.id)" => "seo_url.origem"
									                )
								                ),
                                                $groupBy= false,
                                                $having = false,
                                                $orderBy= 'ordem ASC, titulo ASC, id ASC'
                                            );
                                            
                                            foreach($materiais2 as $k => $material):
                                                $leu = $classLeu->materialLido($material['id']);
                                            ?>
                                                <li class="material-estudo">
                                                	<a href="<?=($material['destino']) ? URL_SITE.$material['destino'] : URL_SITE.'topico/'.$material['id']?>/<?=$materia['id']?>/<?=$disciplina['id']?>/<?=tituloEmURL($material['titulo'])?>"><?=($this->idTopico["topico"] == $material['id'] ? '<i style="vertical-align: sub;" class="material-icons">keyboard_arrow_right</i>' : '<i style="vertical-align: sub;" class="material-icons">keyboard_arrow_down</i>')?><?=$material['titulo']?></a>
                                                	<?if($leu):?><i class="icon-check check-icon"></i><?endif;?>
                                                </li>
                                            <?endforeach;?>
                                    </ul>
                                </li>

                            <?endforeach;?>
                        </ul>
                    </li>
                <?endforeach;?>


            </ul>
      </div>

</div>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/toggle-menu.css" type="text/css" rel="stylesheet" media="screen"/>';
 	$scriptPage = '<script src="'.URL_SITE.'assets/js/components/toggle-menu.js?'.time().'"></script>';
 	
 	if ($this->idTopico["topico"] != "") {
	 	?><script>$(document).ready(function(){ setTimeout(function() { openMenu('<?=$this->idTopico["disciplina"]?>','<?=$this->idTopico["materia"]?>','<?=$this->idTopico["topico"]?>'); }, 1000) });</script><?
 	} else {
	 	?><script>$(document).ready(function(){ setTimeout(function() { openMenu('','','');}, 1000) });</script><?
 	}
?>