<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once(PATH_ABSOLUTO."classes/func.gerais.php");
	require_once(PATH_ABSOLUTO."classes/func.banco.php");
	require_once(PATH_ABSOLUTO."admin/public/includes/routes.php");

	$classRoute = new Route();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
		<meta name="author" content="SignoWEB" />
		<title><?=ADMIN_TITLE?></title>		
		
		<?php include_once(PATH_ABSOLUTO."admin/public/includes/header.php"); ?>
	</head>
	<body class="<?=$classRoute->pagina?>">
		<?php if ($classRoute->pagina !== 'login') : ?>
			<?php include (PATH_ABSOLUTO."admin/public/interface/interface.php") ?>
			<main>
				<nav id="breadcrumbs">
			    	<div class="nav-wrapper">
			    		<a class="breadcrumb" href="javascript:void(0)">Home</a>
			    	</div>
			    </nav>
				<?php $classRoute->includePage() ?>
			</main>
			<?php include (PATH_ABSOLUTO."admin/public/interface/rodape.php") ?>
		<?php else : ?>
			<?php $classRoute->includePage() ?>
		<?php endif ?>
		<script src="<?=URL_ADMIN?>js/materialize.js"></script>
		<script src="<?=URL_ADMIN?>js/materialize-tags.js"></script>		
		<script src="<?=URL_ADMIN?>js/masks.js"></script>
		<script src="<?=URL_ADMIN?>js/init.js"></script>
		<script src="<?=URL_ADMIN?>public/js/main.js"></script>
	</body>
</html>