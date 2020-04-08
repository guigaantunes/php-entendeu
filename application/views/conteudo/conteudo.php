<?php
    $seletor    = $this->id;
    $classBlog  = new Blog;
    
/*
    $blog = $classBlog->getBySeletor($seletor);
    
    if (!$blog) {
        echo "<script>window.location.href = '/'</script>";
    }
*/
    
    $id = $this->parametros[1];
    
    $blog = $classBlog->getAllById($id);
    
    if (!$blog) {
        $blog = $classBlog->getBySeletor($id); 
    }
    
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Conteudo</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a href="/blog" class="select-hover">Blog</a> > 
			<a class="select-hover"><?=$blog['titulo']?></a> 
		</div>
	</div>
</section>

<section class="big-spaces-top">
	<div class="all-content">
		<div class="side-column">
			<? if(!$_GET['dev']==1){
  

				include_once(PATH_ABSOLUTO."application/views/components/toggle-menu-blog.php");
}?>	
		</div>
		<div class="noticia">
			<a class="noticia-title text-orange"><?=$blog['titulo']?></a>
			<a class="subtitle text-grey"><?=ucfirst($blog['data_formatada'])?> | <?=$blog['autor']?></a>
			<img class="noticia-img" src="<?=$blog['image_lg']?>" alt="" />
			<p style="text-align:justify;"class="noticia-content">
	    		<?=html_entity_decode($blog['conteudo'])?>
	        </p>
	        
		    <div class="social-bar">
				<a class="compartilhar">Compartilhar</a>
				<div class="share-noticia">
						<div class="share-icons">
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?=$current_url?>" target="_blank">
    							<i class="icon-facebok"></i>
    				        </a>
							<a href="https://twitter.com/home?status=<?=$current_url?>" target="_blank">
    							<i class="icon-twitter"></i>
    				        </a>
							<a href="https://plus.google.com/share?url=<?=$current_url?>" target="_blank">
                                <i class="icon-google"></i>
                            </a>
						
						</div>
					
					<a class="back-link text-orange" href="<?=URL_SITE?>blog"> ⬅ Voltar para o Blog </a>
				</div>
			</div>   
			<a class="back-link-small text-orange" href="<?=URL_SITE?>blog"> ⬅ Voltar para o Blog </a> 
		</div>
		
		<div class="side-column">
			<? if($_GET['dev']==1){
  include_once(PATH_ABSOLUTO."includes/blog-menu.php");
}?>
		</div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/noticia.css" type="text/css" rel="stylesheet" media="screen"/>';
// 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materiais.js"></script>';
?>