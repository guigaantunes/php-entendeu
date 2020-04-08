<?php
    session_start();
     if( $_GET["login"]==1){
       echo'<script>alert("Faça login ou faça um cadastro");</script>';
     }
    if (isset($_SESSION['cliente']['id'])) {
        echo "<script>window.location.href='/'</script>";
    }
    
    $classConteudo      = new Conteudo;
    $conteudoLogin     = $classConteudo->getById(9);
    $conteudoCadastro   = $classConteudo->getById(10);
if($_GET['planos']=="vip"){
  $escolha = "?planos=vip";
}
else{
  $escolha = "";
}
?>
<section class="section-space">
	<div class="contato">
		<div class="form-box">
			<div><?=$conteudoLogin['conteudo']?></div>
			<a class="title text-gray text-center">Login</a>
			<form id="form-login" method="POST" action="/ajax/ajax.login.php" data-update="true" data-redirect="/planos">
	    		<div class="input-field required" data-error="Informe seu email">
	    			<input id="email" type="text" name="email" placeholder="E-mail" class="required"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="senha" type="password" name="senha" placeholder="Senha" class="required"/>
	    		</div>
	    		<div class="input-field required" >
		    		<a href="javascript:void(0)" class="btn btn-send" id='btn-send'>enviar</a>
	    		</div>
	    		<div>
		    		<a href="#" onclick="esqueciaSenha();">Esqueci a senha?</a>
	    		</div>
	    		<div class="enviar more-space">
    				<button class="btn btn-small orange" type="submit">Entrar</button>
    			</div>
	    		
			</form>
            
			
		</div>
		
		<div class="form-box">
			<div><?=$conteudoCadastro['conteudo']?></div>
			<a class="title text-gray text-center">Cadastro</a>
			<form  class="form" id='form-cadastro' name="f1"method="POST" action="/ajax/ajax.cadastro.php" data-redirect="/minha-conta<?=$escolha?>">
	    		<div class="input-field required" data-error="Informe seu nome">
	    			<input id="nome-cadastro" type="text" name="dados[nome]" placeholder="Nome *" class="required"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe seu Telefone">
	    			<input id="telefone-cadastro" type="text" name="dados[telefone]" placeholder="Celular *" class="required"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe seu email">
	    			<input id="email-cadastro" type="text" onblur="validacaoEmail(f1.dados[email])" name="dados[email]" placeholder="E-mail *" class="required"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="senha-cadastro" type="password" name="dados[senha]" placeholder="Senha *" class="required"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="csenha-cadastro" type="password" name="dados[csenha]" placeholder="Confirmação de senha *" class="required"/>
	    		</div>
          <div class="div-select">
            <p>
              Interesse:
            </p>
            <select style="-webkit-appearance: none;"  name="interesse" form="form-cadastro">
              <option value="OAB">OAB</option>
              <option value="Faculdade">Faculdade</option>
              <option value="Concurso">Prova de concurso</option>
            </select>
        </div>
	    		<div class="input-field required" >
		    		<a href="javascript:void(0)" class="btn btn-send" id='btn-send'>enviar</a>
	    		</div>
	    		
	    		<div class="enviar">
    				<button type="submit"  class="btn green btn-small btn-login">Cadastrar</button>
    			</div>
			</form>
			
		</div>
		
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/login.css" type="text/css" rel="stylesheet" media="screen"/>';
 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/login.js"></script>';
?>