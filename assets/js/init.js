$(document).ready(function () {   
    masks();
});

/*
$(window).load(function () {
    masks();
});
*/

$(document).on("click", ".hamburguer", function(){
	$('.list-menu').toggleClass('active');
	$('body').toggleClass('menu-is-active');
	$(this).toggleClass('active');
});

$(document).on('click', '.btn-show-search', function() {
	$('#busca-topo').addClass('active');
});

$( window ).scroll(function() {
	$("#busca-topo").removeClass("active");
});

function masks() {
	$('.mask-cep').mask('00000-000');
	$('.mask-cpf').mask('000.000.000-00');
	$('.mask-cnpj').mask('00.000.000/0000-00');
	$('.mask-numeric').mask('#0', {
		reverse: true,
		translation: {
			'#': {
				pattern: /-|\d/,
				recursive: true
			}
		},
		onChange: function(value, e) {      
			e.target.value = value.replace(/(?!^)-/g, '').replace(/^,/, '').replace(/^-,/, '-');
		}
	});
	
	$('.mask-money').mask('000.000.000,00', {reverse: true});
	
	$('.mask-date').mask('00/00/0000', {placeholder: '00/00/0000'});
	$('.mask-date-no-placeholder').mask('00/00/0000');
	
	
	$('.mask-time').mask('00:00:00', {placeholder: '00:00:00'});
	$('.mask-datetime').mask('00/00/0000 00:00', {placeholder: '00/00/0000 00:00'});
	
	var SPMaskBehavior = function (val) {
	    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
	    onKeyPress: function(val, e, field, options) {
	        field.mask(SPMaskBehavior.apply({}, arguments), options);
	    }
	};
	$('.mask-telefone').mask(SPMaskBehavior, spOptions);
	$('.mask-telefone-no-ddd').mask('0000-0000');
}


$('body').on('submit', 'form:not(.custom)', function(){
	var form = this;
	
	var dataType = 'json';
	var type = $(form).attr('method') || 'post';
	//var data = $('form').serializeArray();
	var data = $(this).closest('form').serializeArray();
	var maxAttempts = $(form).data('attempts') || 3;
	var url = $(form).attr('action') || window.location.href;
	
	var updateScreen = !!$(form).data('update');
	var datatable = !!$(form).data('datatable');
	var redirect = $(form).data('redirect') ? $(form).data('redirect') : false; 
	
	$.ajax({
		type: type,
		url: url,
		dataType: dataType,
		data: data,
		maxAttempts: maxAttempts,
		attempt: 0,
		updateScreen: updateScreen,
		useDatatable: datatable,
		redirect: redirect,
		success: ajaxDefaultReturn,
		error: function(error) {
			switch (error.status) {
				case 401:
					toast('Você não está logado', 'error');
					setTimeout(function(){
						history.go(0);
					}, 2000);
					break;
				case 403:
					toast('Você não tem permissão para essa ação', 'error');
					break;
				case 500:
					toast('Erro no servidor', 'error');
					toast('Contacte um administrador', 'error');
					break;
				default:
					this.attempt += 1;
					if (this.attempt >= this.maxAttempts) {
						toast('Erro de conexão', 'error');
						toast('Verifique seu acesso a Internet', 'error');
					} else {
						$.ajax(this);
					}
			}
		}
	})
	
	return false;
});


function showToast(message, type) {
    toast(message, 2000, type);
}

function showMessages(mensagens) {
	$.each(mensagens, function(){
		showToast(this.mensagem, this.tipo);
	});
}

function ajaxDefaultReturn(response) {
    console.log(this);
    try {
        response = JSON.parse(response);
    } catch(ex) {}
    
	showMessages(response.mensagens);
	
	if (response.status) {
    	console.log(this.redirect);
    	if(this.redirect) {
        	window.location.href = this.redirect;
    	}
		else if (this.updateScreen) {
            history.go(0);
		} 
		else if (this.useDatatable) {
			$('form').clearInputs();
			
			$.magnificPopup.instance.close();
			//$('.data-table').DataTable().ajax.reload();
		}
	} else if ($('body').hasClass('login')) {
		grecaptcha.reset();
	}
}

$('body')
.on('focus', '.invalid', function(){
	$(this).removeClass('invalid');
})
.on('blur', '.mask-date', function(){
	[d, m, Y] = this.value.split('/');
	var Data = new Date(`${Y}-${m}-${d}`);
	if ( !isNaN(Data.getTime()) ) {
		return true;
	}
	
	if ($(this).is(':required')) {
		$(this).focus();
	}
	
	$(this).addClass('invalid');
	toast('Data inválida', 'error');
})
.on('blur', '.mask-cpf', function(){
	if (CPFValido(this.value)) {
		return true;
	}
	
	if ($(this).is(':required')) {
		$(this).focus();
	}
	
	$(this).addClass('invalid');
	showToast('CPF inválido', 'error');
})
.on('focus', '.mask-cep:not(.cep-initialized)', function(){
	$(this).cep();
	$(this).addClass('cep-initialized');
})
.on('focus', '.mask-money', function(){
	$(this).mask('000.000.000,00', {reverse: true});
});

function CPFValido(strCPF) {
    var Soma = 0;
    var Resto;
    strCPF = strCPF.replace(/\D/g, "");
    
	if (strCPF == "00000000000") return false;
    
	for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
	Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
	
	Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
	
	Resto *= (Resto <= 9);
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}

function deslogar() {
    $.ajax({
        method: 'GET',
        url: '/ajax/ajax.logout.php',
        success: function(data) {
            history.go(0);
        }
    });
}

function esqueciaSenha() {
	// FUNCAO
	var email = $('#form-login #email').val();
	if (email == '') {
		toast('Preencha seu email', 'error');
	} else {
		$.ajax({
	        method: 'GET',
	        url: '/ajax/ajax.esqueciasenha.php?email='+email,
	        success: function(data) {
		        response = JSON.parse(data);
		        showMessages(response.mensagens)
				//toast('teste', 'error')
	        }
	    });
	}
}