<?
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
                $having = false/*
,
                $orderBy= 'ordem ASC'
*/
            );
            
            $topicos[$materia['id']] = $topicos_materia;
        }
        
    }
    
    
/*
    echo "<pre>".print_r($disciplinas,1)."</pre>";
    echo "<pre>".print_r($materias,1)."</pre>";
    echo "<pre>".print_r($topicos,1)."</pre>";
*/
?>

<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Materiais</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a class="select-hover">Materiais</a> 
			
		</div>
	</div>
</section>

<section class="tiny-size spaces-top section-space all-content">
    <script src="/assets/js/pages/materias.js?data=<?=date('YmdHis')?>"></script>
	<div>
		<a class="title text-gray"><?=$conteudoMateriais['titulo']?></a>
		<p class="big-text text-gray text-left"><?=$conteudoMateriais['conteudo']?></p>
	</div>
	
	<div>
		<div class="options-list disciplina-wrapper">
			<a class="big-text text-orange text-left">Escolha uma disciplina</a>
			<div class="options disciplinas">
    			<?
        			foreach($disciplinas as $i => $disciplina):
        			    $leu = $classLido->DisciplinaLida($disciplina['id']);
    			?>
    			    <a href="#materias" class="<?=($leu ? 'btn-green-empty' : 'btn-orange-empty')?> btn go-navigate" data-id-disciplina="<?=$disciplina['id']?>"><?=$disciplina['titulo']?></a>
    			<?endforeach;?>
<!--
				<a class="btn-orange-empty btn">Direito</a>
				<a class="btn-orange-empty btn">Direito</a>
				<a class="btn-orange-empty btn">Direito</a>
-->
			</div>
		</div>
		
		<div id="materias" class="options-list materia-wrapper" style="display:none">
			<a class="big-text text-orange text-left">Escolha uma matéria</a>
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
<!--
			<div class="options materias">
				<a class="btn-orange-empty btn">Direito</a>
				<a class="btn-green-empty btn">Direito</a>
				<a class="btn-orange-empty btn">Direito</a>
				<a class="btn-orange-empty btn">Direito</a>
				<a class="btn-orange-empty btn">Direito</a>
				<a class="btn-orange-empty btn">Direito</a>
				<a class="btn-orange-empty btn">Direito</a>
			</div>
-->
		</div>
		
		<div id="topicos" class="options-list topico-wrapper" style="display:none">
			<a class="big-text text-orange text-left">Escolha um tópico</a>
			<? foreach($topicos as $i => $topicos_materia):?>
    			<div data-id-materia-lista="<?=$i?>" class="options topicos" style="display: none">
        			<?
            			foreach($topicos_materia as $j => $topico):
            			    $leu = $classLido->materialLido($topico['id']);
        			?>
    				    <a data-id-topico="<?=$topico['id']?>" class="<?=($leu ? 'btn-green-empty' : 'btn-orange-empty')?> btn" href="<?=($topico['destino']) ? URL_SITE.$topico['destino'] : URL_SITE.'topico/'.$topico['id']?>"><?=$topico['titulo']?></a>
    				<?endforeach;?>
<!--
    				<a class="btn-green-empty btn">Direito</a>
    				<a class="btn-green-empty btn">Direito</a>
-->
    			</div>
            <?endforeach;?>
		</div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/materiais.css" type="text/css" rel="stylesheet" media="screen"/>';
// 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materiais.js"></script>';
?>