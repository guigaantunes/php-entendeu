<? 
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
  if ($iphone || $ipad || $android || $palmpre || $ipod || $berry ) {
    $cel= false;
  
} else {
    
  $cel= true;
}
?>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
  <link href='https://www.entendeudireito.com.br/application/views/planos/planoss.css' rel='stylesheet' type='text/css'>
  <meta name="viewport" content="width=device-width">
  <script>
    window.console = window.console || function(t) {};
  </script>
  <script>
    if (document.location.search.match(/type=embed/gi)) {
      window.parent.postMessage("resize", "*");
    }
  </script>

  </head>
<section class="section-space all-content center">
	<div class="text-center"style="width:70vw;word-spacing: 2px;line-height:4vh;"> 
		<h1 class="title text-gray">Como funciona?</h1>
		<p style="font-size:2vh"class=" center">Nós trabalharmos com um plano de assinatura, por isso, todo mês o valor é debitado da sua conta, para você não precisar ir ao nosso site e realizar a compra novamente. Você pode CANCELAR QUANDO QUISER e sem pagar taxas. Você pode assinar por 1 mês apenas (informando pelo chat). Por isso, assim que não utilizar mais os nossos serviços, solicite o cancelamento. Visto que, depois que o pagamento é realizado, não é possível fazer o estorno.</div>
    </div>
</section>
  <body translate="no">
    <div class="pricing-container">
      <div class="pricing-switcher">
        <p class="fieldset">
          <input type="radio" name="duration-1" value="monthly" id="monthly-1" checked>
          <label style="color:#155263" for="monthly-1">Mês</label>
          <input type="radio" name="duration-1" value="yearly" id="yearly-1">
          <label style="color:#155263" for="yearly-1">Ano</label>
          <span class="switch"></span>
        </p>
      </div>
      <ul class="pricing-list bounce-invert <? if($cel){ echo " center ";} ?>">
        <li>
          <ul class="pricing-wrapper">
            <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Básico</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">39,
                        90</span> <span class="duration">mês</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 mês de acesso;</li>
                  <li> (Renovado Automáticamente)</li>
                  <li> Acesso a mais de 1500 mapas mentais </li>
                    <li>sem opção de impressão;</li>
                  <li> Conteúdo novo toda semana;</li>
                  <li> Suporte via whatsapp;</li>
                  
                </ul>
              </div>
              <footer class="pricing-footer"> <a class="select" href="https://www.entendeudireito.com.br/checkout?vip=0">Assine</a> </footer>
            </li>
            <li data-type="yearly" class="is-hidden">
              <header class="pricing-header">
                <h2>Básico</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">29,
                        90</span> <span class="duration1">12</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> Acesso por 1 ano</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li>sem opção de impressão;</li>
                  <li> Conteúdo novo toda semana;</li>
                  <li style="color:white"> only</li>
                  
                  <li style="color:white"> only</li>
                </ul>
              </div>
              <footer class="pricing-footer"> <a class="select" href="https://pag.ae/7VGFBizpq">Assine</a> </footer>
            </li>
          </ul>
        </li>
        <li class="exclusive">
          <ul class="pricing-wrapper">
            <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">79,
                        90</span> <span class="duration">mês</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 mês de acesso;</li>
                  <li> (Renovado Automáticamente)</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteúdo novo toda semana;</li>
                  <li> Impressões ilimitadas;</li>
                  <li> Suporte via whatsapp;</li>
                </ul>
              </div>
              <footer class="pricing-footer"> <a class="select" href="https://www.entendeudireito.com.br/checkout?vip=1">Assine</a> </footer>
            </li>
            <li data-type="yearly" class="is-hidden">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">59,
                        90</span> <span class="duration1">12</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> Acesso por 1 ano</li>
                  <li> Mais de 1500 mapas mentais;</li>
                  <li> Conteúdo novo toda semana;</li>
                  <li> Impressões ilimitadas;</li>
                  <li> Suporte via whatsapp;</li>
                  <li> 1 livro + frete grátis</li>
                </ul>
              </div>
              <footer class="pricing-footer"> <a class="select" href="https://pag.ae/7VH3UjJ7K">Assine</a> </footer>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-db44b196776521ea816683afab021f757616c80860d31da6232dedb8d7cc4862.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
    <script id="rendered-js">
      jQuery(document).ready(function($) {
          //hide the subtle gradient layer (.pricing-list > li::after) when pricing table has been scrolled to the end (mobile version only)
          checkScrolling($('.pricing-body'));
          $(window).on('resize', function() {
            window.requestAnimationFrame(function() {
              checkScrolling($('.pricing-body'));
            });
          });
          $('.pricing-body').on('scroll', function() {
            var selected = $(this);
            window.requestAnimationFrame(function() {
              checkScrolling(selected);
            });
          });

          function checkScrolling(tables) {
            tables.each(function() {
              var table = $(this),
                totalTableWidth = parseInt(table.children('.pricing-features').width()),
                tableViewport = parseInt(table.width());
              if (table.scrollLeft() >= totalTableWidth - tableViewport - 1) {
                table.parent('li').addClass('is-ended');
              } else {
                table.parent('li').removeClass('is-ended');
              }
            });
          }
          //switch from monthly to annual pricing tables
          bouncy_filter($('.pricing-container'));

          function bouncy_filter(container) {
            container.each(function() {
              var pricing_table = $(this);
              var filter_list_container = pricing_table.children('.pricing-switcher'),
                filter_radios = filter_list_container.find('input[type="radio"]'),
                pricing_table_wrapper = pricing_table.find('.pricing-wrapper');
              //store pricing table items
              var table_elements = {};
              filter_radios.each(function() {
                var filter_type = $(this).val();
                table_elements[filter_type] = pricing_table_wrapper.find('li[data-type="' + filter_type + '"]');
              });
              //detect input change event
              filter_radios.on('change', function(event) {
                event.preventDefault();
                //detect which radio input item was checked
                var selected_filter = $(event.target).val();
                //give higher z-index to the pricing table items selected by the radio input
                show_selected_items(table_elements[selected_filter]);
                //rotate each pricing-wrapper 
                //at the end of the animation hide the not-selected pricing tables and rotate back the .pricing-wrapper
                if (!Modernizr.cssanimations) {
                  hide_not_selected_items(table_elements, selected_filter);
                  pricing_table_wrapper.removeClass('is-switched');
                } else {
                  pricing_table_wrapper.addClass('is-switched').eq(0).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
                    hide_not_selected_items(table_elements, selected_filter);
                    pricing_table_wrapper.removeClass('is-switched');
                    //change rotation direction if .pricing-list has the .bounce-invert class
                    if (pricing_table.find('.pricing-list').hasClass('bounce-invert')) pricing_table_wrapper.toggleClass('reverse-animation');
                  });
                }
              });
            });
          }

          function show_selected_items(selected_elements) {
            selected_elements.addClass('is-selected');
          }

          function hide_not_selected_items(table_containers, filter) {
            $.each(table_containers, function(key, value) {
              if (key != filter) {
                $(this).removeClass('is-visible is-selected').addClass('is-hidden');
              } else {
                $(this).addClass('is-visible').removeClass('is-hidden is-selected');
              }
            });
          }
        }

      );
      //# sourceURL=pen.js
    </script>
  </body>

  </html>