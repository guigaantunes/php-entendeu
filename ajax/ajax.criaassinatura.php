<?  
  require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
  require_once(PATH_ABSOLUTO."classes/func.gerais.php");
  require_once(PATH_ABSOLUTO."classes/func.banco.php");
  require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
  require_once(PATH_ABSOLUTO."application/controller/iugu.php");
  $classIugu =  new Iugu;
  $classResposta  = new Resposta;
  $id = $_GET["id"];
  $vip = $_GET["vip"];
  $token = $_POST["token"];
  $e= $classIugu->Cliente($id);
  if(array_key_exists("errors",$e)){
      $classResposta->insert($e,Resposta::ERROR, 'e');
      $classResposta->setStatus(false);
    die();
  }
  if($classIugu->FormaDePagamento($id,$vip,$token)){
    //var_dump($classIugu->CriarAssinaturaCartao($id,$vip));
    $r=$classIugu->CriarAssinaturaCartao($id,$vip);
    if( $r['status']!=false){
       $aux = $classResposta->insert("true",Resposta::SUCCESS,'e');
    }else{
      $aux = $classResposta->insert($classIugu->CriarAssinaturaCartao($id,$vip),Resposta::ERROR,'e');
    }
  }
  else{
    $classResposta->insert("Erro com o cartão",Resposta::ERROR, 'e');
  }
?>