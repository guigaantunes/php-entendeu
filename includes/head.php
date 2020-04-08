<!--  Styles !-->
<link href="<?=URL_SITE?>assets/css/init.css" type="text/css" rel="stylesheet" media="screen"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<script src="<?=URL_SITE?>assets/js/jquery1.11.1.min.js"></script>

<script>
	var loadJS = function(url, implementationCode, location){
	    //url is URL of external file, implementationCode is the code
	    //to be called from the file, location is the location to 
	    //insert the <script> element
	
	    var scriptTag = document.createElement('script');
	    scriptTag.src = url;
	
	    scriptTag.onload = implementationCode;
	    scriptTag.onreadystatechange = implementationCode;
	
	    location.appendChild(scriptTag);
	};
	var yourCodeToBeCalled = function(){
	//your code goes here 
    }
    

</script>
<meta charset="UTF-8">
<link rel="icon" type="image/png"  href="/icon.png"
