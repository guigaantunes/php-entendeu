
<?php 

  require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
  require_once(PATH_ABSOLUTO."classes/func.gerais.php");
  require_once(PATH_ABSOLUTO."classes/func.banco.php");
  require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
  require_once(PATH_ABSOLUTO."application/controller/iugu.php");
  $classIugu =  new Iugu;
  $classResposta  = new Resposta;
  if($_POST){
    $dados['id']  = $_POST['id'];
    $dados['vip'] = $_POST['escolha'];
     
    $e= $classIugu->CriarBoleto($dados);
    $classResposta->setStatus(false);
    //var_dump($e);
    //echo $e['errors'];
    //echo $e->status;
    //echo array_key_exists("errors",$e);
    if(array_key_exists("errors",$e)){
      //echo 1;
      $classResposta->insert($e,Resposta::ERROR, 'e');
      $classResposta->setStatus(false);
    }
    else{
      //echo 2;
      $classResposta->insert($e,Resposta::SUCCESS, 'e');
      $classResposta->setStatus(true);
    }
    //echo 3;
  }





?>





?>
