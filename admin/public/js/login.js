$(function(){
	function esqueceuSenha(){
		swal({
				title: "Recuperar Senha",
				text: "Escreva seu email: ",
				type: "input",
				showCancelButton: true,
				closeOnConfirm: false,
				animation: "slide-from-top",
				inputPlaceholder: "Seu e-mail de cadastro...",
				confirmButtonText: 'Enviar',
				cancelButtonText: 'Cancelar'
			},
			function(email){
				if (!email) {
					swal.showInputError("Preencha o campo necessário.");
					return false;
				}
				
				$.ajax({
					type: 'POST',
					url: '/admin/public/ajax/recuperar.senha.php', 
					dataType: 'JSON',
					data: {email: email}
				})
				.done(function(res){						
					showMessages(res.mensagens);
					swal.close();
				});

			}
		);
	}
	
	$('.esqueceu-senha').on('click', esqueceuSenha);
	
	$('body').on('click touchstart', '.badge.caps', function(){
		toast('Caps lock ativado', 'red');
	});
	
	document.onkeydown = detectarCaps;
	document.onkeypress = detectarCaps;
	function detectarCaps( event ) {
		$('label[for=senha] .badge').remove();
			
		if (event.getModifierState && event.getModifierState( 'CapsLock' ))
			$('label[for=senha]').append('<span class="badge caps" style="cursor: pointer" alt="Seu Caps Lock está ativado" title="Seu Caps Lock está ativado"><i class="material-icons left">&#xE002;</i></span>');
			
	}
});