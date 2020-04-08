<?php //var_dump($_SESSION);
	$classAssinatura = new Assinatura;
	//$mostrarBtnAssinatura = $classAssinatura->assinaturaAtiva() && isset($_SESSION['cliente']['id']);
?>
<header class="header">
	<div class="container">
		<div class="row no-margin">
			<div class="col s12">
				<div class="topo">
					<a href="<?=URL_SITE?>" class="logo">
						<img class="img-logo" src="<?=URL_SITE?>assets/images/logo.png" alt="" />
					</a>
					
					<ul class="list-menu">
						<li class="item-menu">
							<a href="<?=URL_SITE?>principal" class="link-menu">Home</a>
						</li>
						<li class="item-menu">
							<a href="<?=URL_SITE?>materiais" class="link-menu">Materiais</a>
						</li>
						<li class="item-menu">
							<a href="<?=URL_SITE?>planos" class="link-menu">Planos</a>
						</li>
						<li class="item-menu">
							<a href="<?=URL_SITE?>blog" class="link-menu">Blog</a>
						</li>
						<li class="item-menu">
							<a href="<?=URL_SITE?>faq" class="link-menu">FAQ</a>
						</li>
						<li class="item-menu">
							<a href="<?=URL_SITE?>contato" class="link-menu">Contato</a>
						</li>
						<?if($_SESSION['cliente']['id']):?>
							<li class="item-menu">
								<a href="<?=URL_SITE?>minha-conta" class="link-menu text-orange">Minha Conta
									<i class="icon-crown text-orange small-text"></i>
								</a>
							</li>
							<li class="item-menu">
								<a href="#" onClick="deslogar()" class="link-menu sair">Sair</a>
							</li>
						<?endif;?>
					</ul>
					
					<div class="botoes-topo">
						<?if( $_SESSION['cliente']['id'] && !$classAssinatura->temAssinatura() ):?>
						    <a href="/planos" class="btn green btn-small assinar-agora-logado green-hover">Assinar Agora</a>
						<?elseif( !$_SESSION['cliente']['id'] ):?>
							<a href="<?=(isset($_SESSION['cliente']['id']) ? '/planos' : '/login')?>" class="btn green btn-small assinar-agora green-hover">Assinar Agora</a>
						<?endif;?>

						<?if( !$_SESSION['cliente']['id'] ):?>
						    <a href="/minha-conta" style="width:90px"class="btn orange btn-small area-do-assinante orange-hover">Login</a>
						<?endif;?>
					</div>
					<a class="hamburguer"><span></span></a>
					<a href="javascript:void(0)" class="btn-show-search"><i class="icon-search"></i></a>
					<form id="busca-topo" method="get" action="/resultado-pesquisa" class="custom">
						<div class="search-form">
							<input type="text" placeholder="Buscar..." name="busca" class="" type="busca"/>
							<button type="submit"><i class="icon-search"></i></button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>    
</header>