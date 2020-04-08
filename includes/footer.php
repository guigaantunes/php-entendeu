<?php
    //#ED6726
    $classConfiguracao  = new Configuracao;
    $classConteudo      = new Conteudo;
    $conteudoDireitos   = $classConteudo->getById(2);
    $conteudoLinks      = $classConteudo->getById(8);
    
    $configuracoes      = $classConfiguracao->getById(1);
?>
<section class="spaces-top">
	<div class="footer">
		<div class="footer-content">
			<ul class="list-menu-footer">
				<span>Menu</span>
				<li>
					<a href="<?=URL_SITE?>principal" class="link-menu">Home</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>materiais" class="link-menu">Materiais</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>planos" class="link-menu">Planos</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>blog" class="link-menu">Blog</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>faq" class="link-menu">FAQ</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>contato" class="link-menu">Contato</a>
				</li>
			</ul>
			
			<ul>
				<span>Contato</span>
				<li>
					<i class="icon-youtube-cinza"></i>
					<a href="https://youtube.com/<?=$configuracoes['youtube']?>" target="_blank" class="link-menu"><span class="icon"></span>/<?=$configuracoes['youtube']?></a>
				</li>
				<li>
					<i class="icon-fb-quadrado-15"></i>
					<a href="https://facebook.com/<?=$configuracoes['facebook']?>" target="_blank" class="link-menu">/<?=$configuracoes['facebook']?></a>
				</li>
				<li>
					<i class="icon-instagram"></i>
					<a href="https://instagram.com/<?=$configuracoes['instagram']?>" target="_blank" class="link-menu">/<?=$configuracoes['instagram']?></a>
				</li>
				<li>
					<a href="/contato" class="link-menu"><!-- entendeudireito@gmail.com --><?=$configuracoes['email_contato']?></a>
				</li>
			</ul>
			
			<ul>
				<span>Link Dinâmicos</span>
				<?=$conteudoLinks['conteudo']?>
<!--
				<li>
					<a href="<?=URL_SITE?>principal" class="link-menu">Link 1</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>sobre" class="link-menu">Link 2</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>equipe-medica" class="link-menu">Link 3</a>
				</li>
				<li>
					<a href="<?=URL_SITE?>exames" class="link-menu">Link 4</a>
				</li>
-->
			</ul>
			
			<div class="direitos-autorais">
				<span>Direitos Autorais</span>
				<p><?=$conteudoDireitos['conteudo']?></p>
			</div>
		</div>
		
		<div class="infos-footer">
			<div class="center">
				
			</div>
			<div class="center">
				<a class="direitos-reservados">Todos os Direitos Reservados © Equipe Entendeu Direito 2019.</a>
			</div>
		</div>
	</div>
</section>