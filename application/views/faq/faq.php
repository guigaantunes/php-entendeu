<?php
    $Faq = new Faq;
    
    $faqs = $Faq->listAll();  
//var_dump($_SESSION);
?>

<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">FAQ</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a class="select-hover">FAQ</a> 
			
		</div>
	</div>
</section>

<section class="big-spaces-top">
	<div class="box-questions">
	<?//var_dump($faqs);?>
    	<?foreach($faqs as $i => $faq):?>
        	<div class="question">
    			<a class="question-title " href="javascript:void(0)"><?=$faq['titulo']?>
    				<i class="icon-arrow btn-icon"></i>
    			</a>
    			<p class="question-answer"><?=$faq['conteudo']?></p>
    		</div>
    	<?endforeach;?>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/faq.css" type="text/css" rel="stylesheet" media="screen"/>';
 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/faq.js"></script>';
?>