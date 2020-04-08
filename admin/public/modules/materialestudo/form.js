$(document).on("ready", function(){
	$( "#tipo" ).change(function() {
		var optionSel = $('#tipo').find(":selected").text();
		
		if(optionSel == 'Arquivo'){
			$('#arquivo-div').fadeIn();
		}else{
			$('#arquivo-div').fadeOut();
		}
	});
	
	if (!$('input[name=id]').val()) {
    	$('#disciplina').trigger('change');
	}
	
});

/*
$('#url').on('focusout', function() {
    $(this).val($(this).val().replace(/[^a-zA-Z0-9]/g, "-"));
});
*/

$('#disciplina').on('change', function() {
   let disciplina = $(this).val();
   let $materias  = $('#materia');
   
   $materias.find('option').remove();
   
    $.ajax({
        url: '/ajax/ajax.listar.materias.php?idDisciplina='+disciplina,
        success: function(data) {
            try{
                data = JSON.parse(data)
            } catch(ex) {}
            
            if (!data) return;
            
            //console.log(data);
            
            $.each(data.dados.materias, function(index, el) {
               $materias.append(`<option value="${el.id}">${el.titulo}</option>`);
            });
            
            $materias.select2();
            
            $materias.trigger('change');
        } 
    });
    
    $materias.select2();
});


$('#materia').on('change', function() {
   let materia = $(this).val();
   let $topicos  = $('#topico');
   
   $topicos.find('option').remove();
   
    $.ajax({
        url: '/ajax/ajax.listar.topicos.php?idMateria='+materia,
        success: function(data) {
            try{
                data = JSON.parse(data)
            } catch(ex) {}
            
            if (!data) return;
            
            //console.log(data);
            
            $.each(data.dados.topicos, function(index, el) {
               $topicos.append(`<option value="${el.id}">${el.titulo}</option>`);
            });
            
            $topicos.select2();

        } 
    });
    
    $topicos.select2();
});