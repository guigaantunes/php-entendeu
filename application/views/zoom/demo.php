
	<style>
		
		/* these styles are for the demo, but are not required for the plugin */
		.zoom {
			display:inline-block;
			position: relative;
		}
		
		/* magnifying glass icon */
		.zoom:after {
			content:'';
			display:block; 
			width:33px; 
			height:33px; 
			position:absolute; 
			top:0;
			right:0;
			background:url(icon.png);
		}

		.zoom img {
			display: block;
		}

		.zoom img::selection { background-color: transparent; }

		#ex2 img:hover { cursor: url(grab.cur), default; }
		#ex2 img:active { cursor: url(grabbed.cur), default; }
		.img{
			align-content: center;
		}
	</style>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script src='<?=URL_SITE."/application/views/zoom/"?>jquery.zoom.js'></script>
	<script>
		$(document).ready(function(){
			$('#ex1').zoom();
			$('#ex2').zoom({ on:'grab' });
			$('#ex3').zoom({ on:'click' });			 
			$('#ex4').zoom({ on:'toggle' });
		});
	</script>

	<span class='zoom' id='ex1'>
		<h1>Passar</h1>
		<img src='<?=URL_SITE."/application/views/zoom/"?>daisy.png' width='600' height='776,46' alt='Daisy on the Ohoopee'/>
	</span>
	<span class='zoom' id='ex3'>
		<h1>Clicar</h1>
		<img src='<?=URL_SITE."/application/views/zoom/"?>daisy.png' width='600' height='776,46'alt='Daisy on the Ohoopee'/>
	</span>

