<?  
    require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
    require_once(PATH_ABSOLUTO."classes/func.gerais.php");
    require_once(PATH_ABSOLUTO."classes/func.banco.php");
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
    require_once(PATH_ABSOLUTO."application/controller/iugu.php");
    $obj['vip'] =  $_POST["vip"];
    $obj['token'] =  $_POST["token"];
    $obj['parcelas'] = $_POST["parcelas"];
    $obj['valor']=$_POST["valor"];
    $classIugu =  new Iugu;
    $classCliente = new Cliente;
    $cliente      = $classCliente->getById($_POST["cliente"]);

    $criar = $classIugu->AssinarAnual($obj,$cliente);
    if($criar=="Cadastrado"){
        echo json_encode( array('mensagens' => "Pagamento realizado", 'dados' => $criar, 'status' => true));
    }
    else{
        echo json_encode( array('mensagens' => "Pagamento não realizado", 'dados' => $criar, 'status' => false));
    }











?>