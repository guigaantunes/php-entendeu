
<?
  require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
  require_once(PATH_ABSOLUTO."application/controller/iugu.php");
  
  $classIugu = new Iugu;
  $r =$classIugu->inserir_logs(166,'json','fsdoahifa');
  echo $r;
?>