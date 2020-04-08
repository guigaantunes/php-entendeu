$(function(){
	
	function realizarLogout(){
		$.ajax({
			type: 'POST',
			url: '/admin/public/ajax/deslogar.php'
		})
		.done(function(res){
			$(location).attr('href','/admin');
		});
	}
	
	$('.deslogar').on('click', realizarLogout);
});