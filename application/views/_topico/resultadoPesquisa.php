<?php

    
    
?>
<section class="big-spaces-top">
	<div class="all-content">
		<div class="side-column">
    		<form >
    			<div class="cards">
    	    		<div class="radio-option small-space">
    		    		<label class="container">
    					  <input id="estudado" type="checkbox" name="estudado">
    					  <span class="checkmark"></span>
    					  <a class="study-mark">CONTEÚDO NÃO ESTUDADO</a>
    					</label>
    	    		</div>
    			</div>
    		</form>
			<input type="text" placeholder="Buscar..." class="search small-space"/>  
			<?php
				include_once(PATH_ABSOLUTO."application/views/components/toggle-menu-material.php");
			?>	
		</div>
		<div class="topico">
			<?if( isset($_SESSION['cliente']['id']) ):?>
				<a class="topico-title text-gray">Considerações Gerais</a>
				<img class="topico-img" src="<?=URL_SITE?>assets/images/img2.png" alt="" />
				<p class="content-terms">A reprodução deste material é condicionada a autorização, sendo terminantemente proibido o seu uso para fins comerciais. A violação do direito autoral é crime, punido com prisão e multa, sem prejuízo de busca e apreensão do material e indenizações patrimoniais e morais cabíveis. Inscrição no INPI: 905146603 para Classe 41 (educação) e 9055146573 para Classe 16 (livros didáticos e congêneres) - Biblioteca Nacional n° 2012/RJ/19521 -641.675, livro 1.233 folha 417 - Website protegido por leis de direitos autorais.</p>
			<?else:?>
				<a class="topico-title conteudo-amostra">Conteúdo de amostra</a>
				<img class="topico-img" src="<?=URL_SITE?>assets/images/img2.png" alt="" />
				<p class="content-terms">Os conteúdos disponibilizados nessa página não estão completos por ser uma versão apenas de teste para usuários que ainda não adquiriram um de nossos planos.</p>
			<?endif;?>
		<a class="back-link text-orange" href="<?=URL_SITE?>materiais"> ⬅ Voltar para Lista de Tópicos</a>
		</div>
		<div class="side-column column-2">
			<div class="print-items">
				<?if( isset($_SESSION['cliente']['id']) ):?>
					<img class="print" src="<?=URL_SITE?>assets/images/print.svg" alt="" />
					<a class="text-print">Clique <br>para<br>imprimir</a>
				<?endif;?>
			</div>
		</div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/topico.css" type="text/css" rel="stylesheet" media="screen"/>';
// 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materiais.js"></script>';
?>