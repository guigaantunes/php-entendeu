$(document).ready(function(){
	$('.question-title ').on("click", function(){
		$(this).parent().find('.question-answer').slideToggle("slow");
	
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		} else {
			$(this).addClass('active');
		}
		
	});
});

/*
$(document).on("click", ".question-title", function(){				
	if ($('.question-title').hasClass('active')) {
		$('.question-title').slideUp();
		$('.question-title').removeClass('active');
		
		$(this).removeClass('active');
	} else {
		$('.question-title').slideDown();
		$('.question-title').addClass('active');
		
		$(this).addClass('active');
	}
});
*/
