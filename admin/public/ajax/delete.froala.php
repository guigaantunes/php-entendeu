<?php
	session_start();	
	require('../includes/default.php');
	necessitaLogin();
	
	$imagem = explode('/', $_POST['src']);
	$imagem = end($imagem);
	$imagem = PATH_ABSOLUTO.'assets/dinamicos/froala/0/'.$imagem;
	
	if (file_exists($imagem))
		unlink($imagem);
		
	echo 'ok';
?>