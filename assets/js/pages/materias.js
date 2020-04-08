$(document).on('click', '.disciplina-wrapper a', showMaterias);
$(document).on('click', '.materia-wrapper a', showTopicos);

$(document).on("click", ".go-navigate",function(){
    var topSec = $($(this).attr('href')).offset().top;
	$('html, body').animate({
		scrollTop: topSec - 100
	}, 1000);
});

function showMaterias(e) {
    let $disciplinas    = $('.disciplina-wrapper');
    let $materias       = $('.materia-wrapper');
    let $topicos        = $('.topico-wrapper');
    
    let idDisciplina    = $(this).data('id-disciplina');
    
    $topicos.fadeOut();
    
    $materias.find('.materias').fadeOut(function() {
        $materias.fadeIn(function() {
            $materias.find(`.materias[data-id-disciplina-lista=${idDisciplina}]`).fadeIn();
        });
    });

        
}

function showTopicos(e) {
    let $disciplinas    = $('.disciplina-wrapper');
    let $materias       = $('.materia-wrapper');
    let $topicos        = $('.topico-wrapper');
    
    let idMateria       = $(this).data('id-materia');
    
    
    $topicos.find('.topicos').fadeOut(function() {
        $topicos.fadeIn(function() {
            $topicos.find(`.topicos[data-id-materia-lista=${idMateria}]`).fadeIn();
        });
    });
        
}