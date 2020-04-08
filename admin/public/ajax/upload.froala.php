<?php
	session_start();	
	require('../includes/default.php');
	
	includeClasses('Upload');
	$Arquivo = new Arquivo;
	$success = $Arquivo->upload($_FILES['file'], 'froala', '0', '', true);
	
	if ($success) {
		$imagem = $Arquivo->getById($success);
		$return = array('link' => URL_SITE . 'assets/dinamicos/froala/0/' . $success . $imagem['arquivo']);
		echo stripslashes(json_encode($return));
	} else {
		echo 'Erro ao fazer upload de imagem';
	}
?>