<?php
  /*require_once(PATH_ABSOLUTO."application/controller/iugu.php"); 
  $classIugu =  new Iugu;
  
  $e = $classIugu->temAssinatura($_SESSION['cliente']['id']);
  echo $e;*/
  
  




?>
<style>
  .plan{
    width: 300px !important;
		height: 550px !important;
  }
  .cartao{
    width:100px;
  }
  .boleto{
    width:100px;
  }
</style>

  <div  style="float:left;padding:1px;border:1px;border-style:solid;border-radius:7px;width:300px">
   
      <a class="center btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#"><img src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png" width="" height="54px" style="border-radius:12px;"></a>

      <a style="margin:0px;color:black;" class="boleto center btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#">Boleto</a>
  </div>
<br></br><br></br>
  <div class="center" style="float:left;padding:1px;border:1px;border-style:solid;border-radius:7px;width:300px">
    
      <a class="center btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#"><img src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png" width="" height="54px" style="border-radius:12px;"></a>
  
      <a style="margin:0px;color:black" class="cartao text-rcenter btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#">Cartao</a>
  </div>
