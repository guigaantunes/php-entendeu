function toast(msg, style, duration){
	duration = duration || 3000;	
	
	if(style == 'success'){
		style = 'cor-admin cor-aprovacao';
	} else if(style == 'error'){
		style = 'cor-admin cor-negacao';
	}
	
	// Materialize 0.97.0
	Materialize.toast(msg, duration, style);
	return true;
	
	// Materialize 1.0.0 beta
	var toast = M.toast({
		html: msg, 
		classes: style
	});
	
	setTimeout(function(){
		toast.dismiss();
	}, duration)
}

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

$.fn.clearInputs = function(){
	this.find("input").each(function(){		
		$(this).val('');
	})
}

$.fn.isValid = function(){	
	const fields = this.find(":input");
	
	var error = false;
	
	fields.each(function(){
		field = $(this);

		if(!field.val() && field.is(":required") && field.is(":visible")){
			error = true;
			field.next().addClass("active");
		}
	});
	
	if(error) {
		toast("Preencha os campos necessários.", "error");
	}
	
	var needConfirmation = $('input[data-confirm]').length > 0;
	$('input[data-confirm]').each(function(){
		var confirmInputId = $(this).attr('data-confirm');
		if ($('#' + confirmInputId).val() !== this.value) {
			error = true;
		}
	});
	
	if(error && needConfirmation) {
		toast("Senhas não são iguais", "error");
	}
	
	return !error;
}

$('body').on('submit', 'form:not(.custom)', function(){
	var form = this;
	
	var dataType = 'json';
	var type = $(form).attr('method') || 'post';
	var data = $('form').serializeArray();
	var maxAttempts = $(form).data('attempts') || 3;
	var url = $(form).attr('action') || window.location.href;
	
	var updateScreen = !!$(form).data('update');
	var datatable = !!$(form).data('datatable');
	
	$.ajax({
		type: type,
		url: url,
		dataType: dataType,
		data: data,
		maxAttempts: maxAttempts,
		attempt: 0,
		updateScreen: updateScreen,
		useDatatable: datatable,
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

function showMessages(mensagens) {
	$.each(mensagens, function(){
		toast(this.mensagem, this.tipo, this.tempo);
	});
}

function ajaxDefaultReturn(response) {
    
    try {
        response = JSON.parse(response);
    } catch(ex) {}
    
	showMessages(response.mensagens);
	
	if (response.status) {
		if (this.updateScreen) {
			history.go(0);
		} else if (this.useDatatable) {
			$('form').clearInputs();
			
			$.magnificPopup.instance.close();
			$('.data-table').DataTable().ajax.reload();
		}
	} else if ($('body').hasClass('login')) {
		grecaptcha.reset();
	}
}

function closeModal(){
	$.magnificPopup.instance.close();
	$('.data-table').DataTable().ajax.reload();
}

function ajaxPopup(url) {
	$.magnificPopup.instance.open({
		items: {
			src: url
		},
		type: 'ajax',
		showCloseBtn: true,
		removalDelay: 500,
		mainClass: 'mfp-zoom-in mfp-large',
		tLoading: '',
		callbacks: {
		    ajaxContentAdded: function() {
			    heightMain();
				pluginsMaterialize();
				//Inicializar o editor de texto
				initHtmlEditor();
				masks();
				
				$(".zozoTabs").zozoTabs();
		    },
		    close: function() {
		    	heightMainReset();
		    }
		}
	}, 0);
}

function confirmAction(title, msg) {
	return new Promise((resolve, reject) => {
		swal({
			title: title,
			text: msg,
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Concluir",
			cancelButtonText: "Cancelar"
		},
		(confirm) => {
			if (confirm) {
				resolve();										
			} else {
				reject();
			}
		});
	});
}

Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "," : d, 
    t = t == undefined ? "." : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

$(function(){
	function submit(){
		var form = $('form#modal');
		
		if(form.isValid()) // @ main.js Function
			$(form).submit();
	}	
	
	$('body').on('click', '.mfp-content .submit', submit);
})