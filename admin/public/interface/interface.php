<script type="text/javascript" src="<?=URL_ADMIN?>public/js/deslogar.js"></script>

<ul id="menu-principal" class="side-nav fixed">	
	<div class="logo"><img src="<?=LOGO_MENU?>" title="<?=TITLE_LOGO?>" alt="<?=TITLE_LOGO?>" /></div>
	<li class="no-padding">
		<ul class="collapsible collapsible-accordion">
			<li>
				<a class="collapsible-header"><i class="material-icons left">&#xE8B8;</i>Sistema<i class="material-icons right">&#xE313;</i></a>
				<div class="collapsible-body">
					<ul>
						<li><a href="<?=URL_ADMIN?>usuarios">Usuários</a></li>
						<li><a href="<?=URL_ADMIN?>configuracao">Configurações</a></li>
<!--
						<li><a href="<?=URL_ADMIN?>banner">Banners</a></li>
						<li><a href="<?=URL_ADMIN?>permissoes">Permissões</a></li>
-->
					</ul>
				</div>
			</li>
		</ul>
	</li>
	<li><a href="<?=URL_ADMIN?>banner"><i class="material-icons left">view_array</i>Banner</a></li>
    <li><a href="<?=URL_ADMIN?>cliente"><i class="material-icons left">person</i>Clientes</a></li>
    <li><a href="<?=URL_ADMIN?>plano"><i class="material-icons left">star_rate</i>Planos</a></li>
    
    <li><a href="<?=URL_ADMIN?>disciplina"><i class="material-icons left">collections_bookmark</i>Disciplinas</a></li>
<!--
    <li><a href="<?=URL_ADMIN?>materia"><i class="material-icons left">book</i>Matérias</a></li>
    <li><a href="<?=URL_ADMIN?>topico"><i class="material-icons left">list</i>Tópicos</a></li>
-->
    
    <li><a href="<?=URL_ADMIN?>material-estudo"><i class="material-icons left">cast_for_education</i>Material de Estudo</a></li>
	<li><a href="<?=URL_ADMIN?>conteudo"><i class="material-icons left">&#xE8EB;</i>Conteúdo</a></li>
	<li class="no-padding">
		<ul class="collapsible collapsible-accordion">
			<li>
				<a class="collapsible-header"><i class="material-icons left">create</i>Blog<i class="material-icons right">&#xE313;</i></a>
				<div class="collapsible-body">
					<ul>
						<li><a href="<?=URL_ADMIN?>categoria-blog">Categoria</a></li>
						<li><a href="<?=URL_ADMIN?>blog">Blog</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</li>
	<li><a href="<?=URL_ADMIN?>faq"><i class="material-icons left">question_answer</i>FAQ</a></li>
</ul>
<header>
	<nav>
		<div class="nav-wrapper">
			<a href="#" data-activates="menu-principal" class="button-collapse left"><i class="material-icons">&#xE5D2;</i></a>
			<a href="#" class="button-minimal-menu left"><i class="material-icons">&#xE5C4;</i></a>
			<a href="#!" class="brand-logo hide-on-large-only"><img src="<?=LOGO_LOGIN?>" title="<?=TITLE_LOGO?>" alt="<?=TITLE_LOGO?>" style="max-height: 70%;" /></a>
			
			<ul class="right hide-on-med-and-down">
				<li><a class="dropdown-nav-bar" href="#!" data-activates="dropdown-conta"><i class="material-icons left">&#xE853;</i><?=$_SESSION['admin']['nome']?><i class="material-icons right">&#xE5C5;</i></a></li>
				<li><a href="#!" class="deslogar"><i class="material-icons">&#xE8AC;</i></a></li>
			</ul>
			
			<a href="#" data-activates="topo-mobile-menu" class="button-collapse-right right"><i class="material-icons">&#xE853;</i></a>
			<ul class="side-nav" id="topo-mobile-menu">
				<li><a href="<?=URL_ADMIN?>public/modules/sistema/usuarios/form.php?id=<?=$_SESSION['admin']['id']?>" class="perfil ajax-popup-link"><i class="material-icons left">&#xE7EF;</i>Perfil</a></li>
				<li class="divider"></li>
				<li><a href="#" class="deslogar"><i class="material-icons left">&#xE879;</i>Sair</a></li>
			</ul>
		</div>
	</nav>
</header>

<ul id="dropdown-conta" class="dropdown-content">
	<li><a href="<?=URL_ADMIN?>/public/modules/sistema/usuarios/form.php?id=<?=$_SESSION['admin']['id']?>" class="perfil ajax-popup-link"><i class="material-icons left">&#xE7EF;</i>Perfil</a></li>
	<li class="divider"></li>
	<li><a href="#" class="deslogar"><i class="material-icons left">&#xE879;</i>Sair</a></li>
</ul>