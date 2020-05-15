<?
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.php';
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Planos.php";
$token = $_POST["token"];
$classResposta  = new Resposta;
$classPlanos = new Planos;




$var = $classPlanos->getPanByCupom($token);
if($var){
    $classResposta->insert($var[0]["id_plan"],Resposta::SUCCESS);
}else{
    $classResposta->insert(false,Resposta::SUCCESS);
}
?>