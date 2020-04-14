<?php	
	error_reporting(0);
	session_start();
	require_once("config.php");
	require_once(PATH_ABSOLUTO."classes/func.gerais.php");
	require_once(PATH_ABSOLUTO."classes/func.banco.php");
	require_once(PATH_ABSOLUTO."includes/routes.php");
// 	require_once(PATH_ABSOLUTO."classes/class.seo.php");
	$classRoute = new Route();
//	$classSeo = new Seo();
	global $stylesPage;
?>
  <!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" prefix="og: http://ogp.me/ns#">

  <head>
    <!-- Facebook Pixel Code -->
    <script>
      ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
          n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
      }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '2986197504726663');
      fbq('track', 'PageView');
    </script>
    <noscript>
       <img height="1" width="1" 
      src="https://www.facebook.com/tr?id=2986197504726663&ev=PageView
      &noscript=1"/>
      </noscript>
    <!-- End Facebook Pixel Code -->
    <!-- RD -->
    <script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/f41cbe14-d41b-4af3-b835-1ab2f5061e6e-loader.js"></script>

    <!--    <script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/unique-methods/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">window.dojoRequire(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us20.list-manage.com","uuid":"3408a3cc1bbfc1ec5c33075ca","lid":"3bcad5e007","uniqueMethods":true}) })</script>
	 Mail Chimp 
		<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}			
		(document,"script","https://chimpstatic.com/mcjs-connected/js/users/3408a3cc1bbfc1ec5c33075ca/7cc57fb17b2552fe1de3ffeb8.js");</script>
	    -->
   <script type='text/javascript'>
  window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', 'e018d975bc9d1786858048975590a91bebe4f49f');
</script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111688419-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-111688419-1');
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="author" content="Claudia Rocha Franco Lopes" />
    <?php $classRoute->includeMetas(); ?>

    <link rel="shortcut icon" href="<?=URL_SITE?>ico.png" type="image/x-icon">
    <link rel="icon" href="<?=URL_SITE?>ico.png" type="image/x-icon">


    <!--  Styles !-->
    <link href="<?=URL_SITE?>assets/css/init.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="<?=URL_SITE?>assets/js/jquery1.11.1.min.js"></script>
    <script src="//code.jivosite.com/widget.js" data-jv-id="9g23H69wjl" async></script>





  </head>

  <body>
    <?php
		
		$urldosite =explode("/", str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]));
		if($urldosite [1]=="single-post"){
      //echo PATH_ABSOLUTO."application/views".$_SERVER["REQUEST_URI"]."/".$urldosite[5].'.php' ;
		    include_once(PATH_ABSOLUTO."includes/header.php");
		   if(include_once(PATH_ABSOLUTO."application/views".$_SERVER["REQUEST_URI"]."/".$urldosite[5].'.php')){
		        include_once(PATH_ABSOLUTO."application/views".$_SERVER["REQUEST_URI"]."/".$urldosite[5].'.php');
		        include(PATH_ABSOLUTO."includes/assetsPage.php");
		       include_once(PATH_ABSOLUTO."includes/footer.php");
		       
		   }else{
		        
		       include (PATH_ABSOLUTO."application/views/404.php");
		       include(PATH_ABSOLUTO."includes/assetsPage.php");
		       include_once(PATH_ABSOLUTO."includes/footer.php");
		   }
		   
		}
		else{
			include_once(PATH_ABSOLUTO."includes/header.php"); 	
		?>
      <main>
        <?php
				$classRoute->includePage();
				include(PATH_ABSOLUTO."includes/assetsPage.php");
			?>
      </main>
      <?php
			include_once(PATH_ABSOLUTO."includes/footer.php"); 	}
		?>

        <!--  Styles !-->
        <link href="<?=URL_SITE?>assets/css/style.css" type="text/css" rel="stylesheet" media="screen" />
        <!--  Scripts !-->
        <?=$stylesPage?>

          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
          <script src="<?=URL_SITE?>assets/js/plugins/swiper.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js?<?=time()?>"></script>
          <script src="<?=URL_SITE?>assets/js/plugins/toast.js"></script>
          <script src="<?=URL_ADMIN?>public/js/jquery.cep.js"></script>
          <script src="<?=URL_SITE?>assets/js/init.js?<?=time()?>"></script>
          <?=$scriptPage?>
  </body>

  </html>
