<? 

  require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
  require_once(PATH_ABSOLUTO."classes/func.gerais.php");
  require_once(PATH_ABSOLUTO."classes/func.banco.php");
  require_once(PATH_ABSOLUTO."application/controller/iugu.php"); 
  
  $classIugu =  new Iugu;
  
  $assinatura = $classIugu->temAssinatura($_SESSION['cliente']['id']);
  if(!$assinatura || !isset($_SESSION['cliente']['id'])){
    echo '<script>
          $(window).on("load", function() {
              showToast("Não achamos a sua assinatura, favor entrar em contato","error");
          });
          </script>';
  }  


?>