<?php 
  
  require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
  require_once(PATH_ABSOLUTO."classes/func.gerais.php");
  require_once(PATH_ABSOLUTO."classes/func.banco.php");
  require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
  require_once(PATH_ABSOLUTO."application/controller/iugu.php"); 
  require_once(PATH_ABSOLUTO."application/controller/Planos.php"); 
  $classIugu =  new Iugu;
  $classResposta  = new Resposta;
  $id =  $_GET["id"];
  $vip = $_GET["vip"];
  $rr= $classIugu->temAssinatura($id);
if( $rr==true ||$rr=="Você possui mais de uma assinatura, por favor entre em contato pelo nosso chat."){
       echo'<script>alert("Ja possui assinatura")</script>';
        echo "<script>window.location.href = '/materiais'</script>";
     }
else{
  $e= $classIugu->criarboleto($id,$vip);
  
  echo "<script>window.location.href = '$e'</script>";
}



?>
