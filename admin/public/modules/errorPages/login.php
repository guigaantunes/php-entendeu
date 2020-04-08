<script type="text/javascript" src="<?=URL_ADMIN?>public/js/login.js"></script>

<!-- // LOGIN -->

<div class="page-login">
	<img class="icone-admin" src="<?=ICONE_LOADING?>" />
	<img class="logo-admin" src="<?=LOGO_LOGIN?>" title="<?=TITLE_LOGO?>" alt="<?=TITLE_LOGO?>"  />
	<div class="box-login">
		<form id="login" action="/admin/public/ajax/login.php" data-update="true">
			<div class="row">
				<div class="input-field col s12">
					<i class="material-icons prefix">&#xE7FF;</i>
					<input name="email" id="email" type="text" class="validate" value="<?=@$_COOKIE["lembrarEmail"]?>">
					<label for="email" data-error="Email não cadastrado">EMAIL</label>
				</div>
				<div class="input-field col s12">
					<i class="material-icons prefix">&#xE899;</i>
					<input name="senha" id="senha" type="password" class="validate">
					<label for="senha" data-error="Senha incorreta">SENHA</label>
				</div>
				<div class="col s12">
					<div class="g-recaptcha" data-sitekey="<?=CAPTCHA_SITEKEY?>"></div>
				</div>
				<div class="esqueceu-senha col s12">
					<a href="javascript:void(0)">Esqueceu sua senha?</a>
				</div>
				<div class="lembrar-de-mim col s12">
					<input type="checkbox" class="cor-admin cor-detalhe" id="lembrar" name="lembrar" <?=(isset($_COOKIE["lembrarEmail"]) ? "checked " : "")?>/>
					<label for="lembrar">Lembrar de mim?</label>
				</div>
			</div>
			
			<div class="row">
				<button class="btn-large waves-effect waves-light cor-admin cor-detalhe" type="submit">Entrar</button>
			</div>
		</form>
	</div>
</div>

<!-- LOGIN // -->