<?php 
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
require_once(PATH_ABSOLUTO."classes/func.gerais.php");
require_once(PATH_ABSOLUTO."classes/func.banco.php");
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
$classResposta  = new Resposta;

if ($_GET) {
  require_once(PATH_ABSOLUTO."application/controller/iugu.php");

  $iugu =  new CurlIugu;

  $ll = $iugu->ListarClientes();
  $data = $ll->items;
  var_dump($ll->items);
  echo data($data);
}
?>
