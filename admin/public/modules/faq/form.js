$(document).on("ready", function(){
	$( "#tipo" ).change(function() {
		var optionSel = $('#tipo').find(":selected").text();
		
		if(optionSel == 'Arquivo'){
			$('#arquivo-div').fadeIn();
		}else{
			$('#arquivo-div').fadeOut();
		}
	});
});