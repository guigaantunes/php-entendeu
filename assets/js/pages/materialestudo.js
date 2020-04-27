$(document).on('change', '#estudado', alterarStatus);
$(document).on('click', '.text-print', proccessPDF);

$(document).ready(function() {
    $('.topico-img').bind("contextmenu", function(e) {
        e.preventDefault();
    });    
});


function alterarStatus(e) {
    let lido    = ($(this).prop('checked') ? 1 : 0);
    let id      = $('#id').val();
    let $texto  = $('.study-mark');
   
   
    
    $texto.text((lido ? 'CONTEÚDO ESTUDADO' : 'CONTEÚDO NÃO ESTUDADO'));
    
    $.ajax({
        method: 'POST',
        url:    "/ajax/ajax.material.lido.php",
        data: {dados:{id: id, status: lido}}
    });
    
    $(document).ready(function(){
		if ($('.study-mark').hasClass('.active')) {
			$(this).removeClass('.active');
		} else {
			$(this).addClass('.active');
		}
	});
}

function proccessPDF() {
    
    let file_id = $(this).data('file-id');
    window.open('/ajax/ajax.protect.pdf.php?file_id=' + file_id,'_blank');

    /*$.ajax({
        url: '/ajax/ajax.valida.assinatura.php',
        success: function(data) {
            try {
                data = JSON.parse(data);
            } catch(ex) {}
            
            if (data.status) {
                window.open('/ajax/ajax.protect.pdf.php?file_id=' + file_id,'_blank');
            }
        }
    })
    .done(ajaxDefaultReturn);*/
    

    
/*
    $.ajax({
        'url': '/ajax/ajax.protect.pdf.php?file_id=' + $(this).data('file-id')
    })
    .done(ajaxDefaultReturn);
*/
}

$(document).on("click", ".item-slide", function(){
	var src = $(this).find('img').attr('src');
	$(this).addClass('active');
	$(this).siblings().removeClass('active');
	$('#img-dinamic').attr('src', src);
// 	changeSlideHeight();
});
function toggleBtn(botao){
	var elemento;
	switch(botao){
		case 1: elemento = $(".btnPesquisarInput input"); break;
		case 2: elemento = $(".btnMaisBotoesGrupo"); break;
		//case 3: Clique aqui para saber mais sobre o diálogo!
		}
	
	if(elemento.is(":visible")){
		elemento.hide(300);
	}else{
		elemento.show(300);
		// elemento.focus(); -- Focar o campo caso seja texto
	}
	
	// Se quiser que o botão pesquisa feche ao desfocar o input
	// $(".btnPesquisarInput input").blur(function(){ toggleBtn(1); });
}

$(".btnPesquisarBtn button, .btnMaisBotoesBtn button, .btnSupEsquerdo button").click(function(){
	var botao = $(this).attr("name");
	botao = parseInt(botao);
	toggleBtn(botao);
});