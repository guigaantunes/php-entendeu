$(document).ready(function(){
	if ($('.container').hasClass('.active')) {
		$(this).removeClass('.active');
	} else {
		$(this).addClass('.active');
	}
});
