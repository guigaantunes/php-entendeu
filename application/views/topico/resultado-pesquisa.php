<?php
if(!$_SERVER["REMOTE_ADDR"]=="177.83.19.24"){
	die();
}
//echo $_SERVER["REMOTE_ADDR"];
    //$Pagseguro          = new Pagseguro;
	$classMaterialEstudo= new MaterialEstudo;
	$classMateria =  new Materia;
	$buscaMateria = $classMateria->getTitulos($_GET["busca"]);
	$buscaMaterialEstudo = $classMaterialEstudo->getTitulos($_GET["busca"]);
	if(count($buscaMaterialEstudo) <= 0 && count($buscaMateria) <= 0){
		$mostrar["materia"] =  false;
		$mostrar["topico"] =  false;
	}
	else if(count($buscaMaterialEstudo) >= 0 && count($buscaMateria) <= 0){
		$mostrar["topico"] =  true;
		$mostrar["materia"] =  false;
	}
	else if(count($buscaMaterialEstudo) <= 0 && count($buscaMateria) >= 0){
		$mostrar["materia"] =  true;
		$mostrar["topico"] =  false;
	}
	else{
		$mostrar["materia"] =  true;
		$mostrar["topico"] =  true;
	}
	$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
	$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
	$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
	$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
	$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
	$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
	$symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
	
	if ($iphone || $ipad || $android || $palmpre || $ipod || $berry ) {
		$styless="";
	} else {
		$styless="all-content";
	}
?>
<link href="<?=URL_SITE?>assets/css/topico.css" type="text/css" rel="stylesheet" media="screen"/>
<script src="<?=URL_SITE?>/assets/js/pages/materias.js?data=<?=date('YmdHis')?>"></script>
<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Busca</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a href="/materiais" class="select-hover">Materiais</a> > 
			<a class="select-hover">Busca</a> 
		</div>
	</div>
</section>

<section class="">
    <script src="<?=URL_SITE?>assets/js/pages/materialestudo.js?d=<?=date('YmdHis')?>"></script>
	<div class="<?=$styless?>">
		
		<?if($mostrar ["materia"]){?>
			
		<div class="topico">
			<h1>Materias</h1>
			<?foreach($buscaMateria as $i => $materia):?>
				<div class="center no-margin" style="float:left">
        			<img src="<?=URL_SITE?>application/views/materiais/<?echo str_replace(" ","", $materia['titulo'],$semespaco);?>.png" width="" height="54px" style="border-radius:12px;padding-right:20px"></img>
    				<a data-id-topico="<?=$materia['id']?>" style ="border-left-width: 0px;position:relative;top:5px;left:-20px;width: 200px; border-top-left-radius:0px !important;border-bottom-left-radius:0px !important;height:54px;font-size:1rem;"class="btn-orange-empty btn" href=""><?=$materia['titulo']?></a>
    			</div>
			<?endforeach;
			
		}?>
		</div>
		<?if($mostrar ["topico"]){?>

		<div class="topico <?if($mostrar["materia"]==false){echo "center";}?>">
			<h1>Topicos</h1>
			
			<?foreach($buscaMaterialEstudo as $i => $conteudo):?>
			<div style="padding:0px" class="topico ">
			<a  class=" text-left link-topico" href="<?=URL_SITE."topico/".$conteudo["id"]."/".$conteudo["id_materia"]."/"."1/".tituloEmURL($conteudo["titulo"])?>"><i style="margin-right:1rem;font-size:1.2rem;vertical-align: sub;" class="material-icons">radio_button_unchecked</i><?=$conteudo["titulo"]?></a>
			</div>
		
			<?endforeach;
		}?>
		</div>
		<?
		if($mostrar ["materia"]==false && $mostrar ["topico"]==false){?>
			<h1>Não achamos nem um mapa mental<h1>
			<p>Gostaria de sugerir algum topico?</p>
			<p>Entre em contato pelo chat<p>	
		<?}?>

			
		</div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/topico.css" type="text/css" rel="stylesheet" media="screen"/>';
 	//$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materialestudo.js"></script>';
?>

