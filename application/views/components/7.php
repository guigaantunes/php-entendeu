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
	<form id="busca-topo" method="get" action="/resultado-pesquisa" class="custom">
		<div class="search-form">
	    	<input type="text" placeholder="Buscar..." name="busca" class="search small-space" type="busca" value=""/>
		</div>
	</form>	
<!--<div class="search-items">
	<input autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" type="text" placeholder="Buscar..." class="search small-space" value="<?=$busca?>"/>
	<i class="icon-search search-topico"></i> 
</div>-->
<div class="toggle-menu">
    <a class="title-menu"><?php $id_toggle = explode("/", $_SERVER['REQUEST_URI']);
	                            foreach($disciplinas as $i => $disciplina):
                           
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
                                            $cont=0;
                                            foreach($materiais2 as $k => $material):
                                                $leu = $classLeu->materialLido($material['id']);
                                                
                                                if($materia['id']==$id_toggle[3] && $cont==0){
                                                    echo $materia['titulo'];
                                                    $cont = $cont+1;
                                                
                                            }endforeach;?>
                            <?endforeach;?>
                <?endforeach;?>
	                            
                            
	<div class="dropdown">
            <ul class="lista-menu">
                <?foreach($disciplinas as $i => $disciplina):?>
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
                            
                                
                                	<ul class="item-second-level" href="javascript:void(0)"> 
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
                                               if($materia['id']==$id_toggle[3]){
                                            ?>
                                                <li style="z-index:1;"class="item-second-level">
                                                	<p style="max-width: 20ch;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;<?if($leu):?>color:#59DE1B !important;<?else:?>color:white;<?endif;?>"><a style="<?if($leu):?>color:#59DE1B !important;<?else:?><?endif;?>"href="<?=($material['destino']) ? URL_SITE.$material['destino'] : URL_SITE.'topico/'.$material['id']?>/<?=$materia['id']?>/<?=$disciplina['id']?>/<?=tituloEmURL($material['titulo'])?>"><?=($this->idTopico["topico"] == $material['id'] ? '<i style="vertical-align: sub;" class="material-icons">radio_button_checked</i>' : '<i style="vertical-align: sub;" class="material-icons">radio_button_unchecked</i>')?><?=$material['titulo']?></a></p>
                                                	
                                                </li>
                                            <?}endforeach;?>
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