<?php

	require __DIR__ . '/froala/lib/FroalaEditor.php';
	
	$response = FroalaEditor_Image::getList('/uploads/');
	
	echo stripslashes(json_encode($response));
?>