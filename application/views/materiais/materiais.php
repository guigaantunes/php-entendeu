<?
	$_SESSION['voltar'] = 'demonstrativos';
	
    $classLido          = new ClienteLeuMaterial;
    $classMaterialEstudo= new MaterialEstudo;
    $classDisciplina    = new Disciplina;
    $classMateria       = new Materia;
//     $classTopico     = new Topico;
    $classConteudo      = new Conteudo;
    
    $conteudoMateriais  = $classConteudo->getById(6);
    
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
    
    $materias   = array();
    $topicos    = array();
    
    foreach($disciplinas as $i => $disciplina) {
        $materias_disciplina = $classMateria->getBy(
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
        
        $materias[$disciplina['id']] = $materias_disciplina;
        
        foreach($materias_disciplina as $j => $materia) {
            $topicos_materia = $classMaterialEstudo->getBy(
                $dados  = array(
                    'materialestudo.status'         => 1,
                    'materialestudo.id_materia'     => $materia['id'],
                    'materialestudo.demonstrativo'  => 1
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
            
            $topicos[$materia['id']] = $topicos_materia;
        }
        
    }
    
    
    
    /* Filtra somente disciplinas, mat茅rias que possuem t贸picos demonstrativos */
    $topicos = array_filter($topicos, function($el) {
        return !empty($el);
    });

    foreach($materias as $i => $materia) {
        $materias[$i] = array_filter($materias[$i], function($el) use($topicos) {
            return in_array($el['id'], array_keys($topicos));
        });
    }
    $materias = array_filter($materias, function($el) {
        return !empty($el);
    });
    
    $disciplinas = array_filter($disciplinas, function($el) use($materias) {
        return in_array($el['id'], array_keys($materias));
    });
?>

<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Materiais</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a class="select-hover">Materias</a> 
			
		</div>
	</div>
</section>

<section class="tiny-size spaces-top section-space all-content" <?php
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");

if ($iphone || $ipad || $android || $palmpre || $ipod || $berry ) {
    echo "";
} else {
    $styless='style="width:1000px;"';
    
    echo $styless;
}
?>
    <script src="/assets/js/pages/materias.js?data=<?=date('YmdHis')?>"></script>
	<div>
		<a class="title text-gray"><?=$conteudoMateriais['titulo']?></a>
		<p class="big-text text-gray text-left"><?=$conteudoMateriais['conteudo']?></p>
	</div>
	
	<div>
		<div class="options-list disciplina-wrapper">
			<div class="options disciplinas">
    			<?
        			foreach($disciplinas as $i => $disciplina):
        			    $leu = $classLido->DisciplinaLida($disciplina['id']);
        			    if (in_array($disciplina['id'], array_keys($materias))):
    			?>
    			    
    			<?
        			    endif;
        			endforeach;
                ?>
			</div>
		</div>
		
		<div id="materias" class="options-list materia-wrapper" style="display:none">
			<?foreach($materias as $i => $materias_disciplina):?>
			    <div data-id-disciplina-lista="<?=$i?>" class="options materias" style="display: none">
    			    <?
        			    foreach($materias_disciplina as $j => $materia):
        			        $leu = $classLido->materiaLida($materia['id']);
    			    ?>
    				    <a href="#topicos" data-id-materia="<?=$materia['id']?>" class="<?=($leu ? 'btn-green-empty' : 'btn-orange-empty')?> btn go-navigate"><?=$materia['titulo']?></a>
    				<?endforeach;?>
    			</div>
            <?endforeach;?>
		</div>
		
		<div id="topicos" class="options-list topico-wrapper center" style="display:block">
			<a class="big-text text-orange text-left">Escolha um tópico</a>
			<? foreach($topicos as $i => $topicos_materia):?>
    			<div data-id-materia-lista="<?=$i?>" class="" style="display: block">
        			<?
            			foreach($topicos_materia as $j => $topico):
            			    $leu = $classLido->materialLido($topico['id']);
            			  
            			    
        			?> 
        		<div class="center" style="float:left;padding:1px">
        		    
        			<img src="<?=URL_SITE?>application/views/materiais/<?foreach($materias_disciplina as $j => $materia):  if($topico['id_materia']==$materia['id']){echo str_replace(" ","", $materia['titulo'],$semespaco);}endforeach;?>.png" width="" height="54px" style="border-radius:12px;padding-right:20px"></img>
    				<a data-id-topico="<?=$topico['id']?>" style ="border-left-width: 0px;position:relative;top:5px;left:-20px;width: 200px; border-top-left-radius:0px !important;border-bottom-left-radius:0px !important;height:54px;font-size:1rem;"class="<?=($leu ? 'btn-green-empty' : 'btn-orange-empty')?> btn" href="<?=($topico['destino']) ? URL_SITE.$topico['destino'] : URL_SITE.'topico/'.$topico['id']?>/<?=$topico['id_materia']?>/<?=search_array($materias, "id", $topico['id_materia'])[0]['id_disciplina']?>/<?=tituloEmURL($topico['titulo'])?>"><?$id_disciplina=$topico['id_disciplina'];$id_materias= $topico['id_materia'];?><?foreach($materias_disciplina as $j => $materia):  if($topico['id_materia']==$materia['id']){echo $materia['titulo']; }endforeach;?></a>
    				</div>
    			
    				<?endforeach;?>
    			</div>
            <?endforeach;?>
		</div>
		
<!--
		<div id="demonstrativos" class="options-list demonstrativos-wrapper">
			<a class="big-text text-orange text-left">Materiais Demonstrativos</a>
			<div data-id-materia-lista="<?=$i?>" class="options demonstrativos">
    			<?
        			foreach($demonstrativos as $i => $topico):
        			    $leu = $classLido->materialLido($topico['id']);
    			?>
				    <a data-id-topico="<?=$topico['id']?>" class="<?=($leu ? 'btn-green-empty' : 'btn-orange-empty')?> btn" href="<?=($topico['destino']) ? URL_SITE.$topico['destino'] : URL_SITE.'topico/'.$topico['id']?>"><?=$topico['titulo']?></a>
				<?endforeach;?>
			</div>
		</div>
-->
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/materiais.css" type="text/css" rel="stylesheet" media="screen"/>';
// 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materiais.js"></script>';
?>