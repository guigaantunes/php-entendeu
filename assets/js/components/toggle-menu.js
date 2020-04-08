/*$(document).on("click", ".first-level", function(){
					
	if ($('.first-level').parent('.second-level').hasClass('active')) {
		$('.first-level').parent('.second-level').slideUp();
		$('.first-level').parent('.second-level').removeClass('active');
		
		$(this).removeClass('active');
	} else {
		$('.first-level').parent('.second-level').slideDown();
		$('.first-level').parent('.second-level').addClass('active');
		
		$(this).addClass('active');
	}
});

$(document).on("click", ".option-second-level", function(){
					
	if ($('.option-second-level').parent('.third-level').hasClass('active')) {
		$('.option-second-level').parent('.third-level').slideUp();
		$('.option-second-level').parent('.third-level').removeClass('active');
		
		$(this).removeClass('active');
	} else {
		$('.option-second-level').parent('.third-level').slideDown();
		$('.option-second-level').parent('.third-level').addClass('active');
		
		$(this).addClass('active');
	}
});*/

$(document).ready(function(){
	$('.first-level').click(function(){
		$(this).parent().find('.second-level').slideToggle("slow");
	});
	
	if ($('.first-level').hasClass('active')) {
		$(this).removeClass('active');
	} else {
		$(this).addClass('active');
	}
});

$(document).ready(function(){
	$('.option-second-level').click(function(){
		$(this).parent().find('.third-level').slideToggle("slow");
	});
});


$(document).on('keyup', '.search', searchTopics);
//$(document).on('keyup', '.search', setTimeout(openMenu, 1000) );

function openMenu(disciplina, materia, topico){
	console.log('abrir menu, topico => '+topico+'....');
	
	let $disciplinas2        = $('.item-first-level');
	let $materias2           = $('.item-second-level');

	// Abrir todos os menus no primeiro carregamento.
	if (topico == '') {
		setTimeout(function(){ $('.search').trigger('keyup'); }, 500);
		setTimeout(function(){ 
			$.each($disciplinas2, function(i, e) {
		        if ($(e).hasClass('hidden')) {  
		        } else {
			    		$(e).children('a').trigger('click');
		        }
		    });
		    
		    
		    $.each($materias2, function(i, e) {
		   		$(e).children('a').trigger('click');
		    });
		}, 1000);
		/*
		searchTopics();
	    $.each($disciplinas2, function(i, e) {
	        if ($(e).hasClass('hidden')) {  
	        } else {
		    		$(e).children('a').trigger('click');
	        }
	    });
	    
	    
	    $.each($materias2, function(i, e) {
	   		$(e).children('a').trigger('click');
	    });
		*/
	} else {
	// Abrir apenas do topico acessado.
		$.each($disciplinas2, function(i, e) {
			if ($(e).data('id') == disciplina) {
				$(e).children('a').trigger('click');
			}
	    });
	    
	    $.each($materias2, function(i, e) {
	   		if ($(e).data('id') == materia) {
				$(e).children('a').trigger('click');
			}
	    });
		
	}
}

function searchTopics(e) {
    let searchString = $(this).val().toLowerCase();
    
    //let $listaTopicos       = $('.lista-menu');
    let $topicos            = $('.material-estudo');
    let $disciplinas        = $('.item-first-level');
    let $materias           = $('.item-second-level');
    $.each($topicos, function(i,e) {
        let topicoTitulo = $(e).find('a').text().toLowerCase();
        
        if (topicoTitulo.search(searchString) < 0 && searchString.trim().length > 0) {
            $(e).hide();
            $(e).addClass('hidden');
        } else {
            $(e).show();
            $(e).removeClass('hidden');
        }
    });
    
    $.each($materias, function(i, e) {
        if (!$(e).find('.material-estudo:not(.hidden)').length && searchString.trim().length > 0) {
            $(e).hide();
            $(e).addClass('hidden');
        } else {
            $(e).show();
            $(e).removeClass('hidden');
        }
    });
    
    $.each($disciplinas, function(i, e) {
        if (!$(e).find('.item-second-level:not(.hidden)').length && searchString.trim().length > 0) {
            $(e).hide();
            $(e).addClass('hidden');
        } else {
            $(e).show();
            $(e).removeClass('hidden');
        }
    });
    
    if (!$(document).find('.material-estudo:not(.hidden)').length) {
        $(document).find('.dropdown .msg-empty').remove();
        $('.dropdown').append('<span class="msg-empty" style="color:white">Não foram econtrados resultados...</span>');
    } else {
        $(document).find('.dropdown .msg-empty').remove();        
    }
    
    //setTimeout(openMenu, 2000);

}
