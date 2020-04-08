<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ajax/lib/ApiMailchimp.php');
	ob_start();
	
	includeClasses('Resposta');
	//necessitaLogin();
	$MailChimp          = new MailChimp(MAILCHIMP_KEY);
	$class              = new Cliente;
	$classAssinatura    = new Assinatura;
	$Pagseguro          = new PagSeguroRecorrencia;
	$modulo = "cliente";	
	$registros = $class->getBy(
		    $dados = array(
			    'cliente.status' => 1
            ),
            $campos = array(
    			'cliente.*',
    			'cliente.id AS DT_RowId',
    			'DATE_FORMAT(cliente.data_cadastro, "%d/%m/%Y %H:%i:%s") as data_cadastro_f'
            ),
            $inner  = false,
            $left   = false,
            $groupBy= false,
            $having = false,
            $orderBy= 'id ASC'
		);
		//var_dump($registros);
    		
            /*foreach($registros as $i => $r) {
              temAcessoBasico([$i]['id']);
              temAcessoVip([$i]['id']);
		    }*/
		    /*temAcessoBasico($registros[1000]['id']);
		    echo "<pre>";
    		var_dump($registros );
            echo "<pre>";
            die();*/
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
</head>
<body>
    <div class="container">
       <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Acesso VIP Manual</th>
                    <th>Acesso Básico</th>
                    <th>Acesso VIP</th>
                </tr>
            </thead>
            <tbody>
                
                <?foreach($registros as $i => $r){?>                
                <tr>
                    <th><?=$registros[$i]['id']?></th>
                    <th><?=$registros[$i]['nome']?></th>
                    <th><?=$registros[$i]['email']?></th>
                </tr>
                <?}?>
            </tbody>
        </table>       
    </div>
</body>