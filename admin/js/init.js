$(document).ready(function(){
	
	//Inicializar plugins do materialize
	pluginsMaterialize();
	
	$(".button-collapse").sideNav();
	$('.button-collapse-right').sideNav({
		edge: 'right', // Choose the horizontal origin
	});
	
	$('.button-minimal-menu').on('click', function(){
		$('#menu-principal').toggleClass("minimal");
	    if ($('#menu-principal').is('.minimal')) {
		    $(".button-minimal-menu i").html('&#xE5C8;');
	    } else {
		    $(".button-minimal-menu i").html('&#xE5C4;');
	    }
	});
	
	$.magnificPopup.instance._onFocusIn = function(e) { 
		// Do nothing if target element is select2 input
		e = $("select");
		return true; 
		
		// Else call parent method 
		$.magnificPopup.proto._onFocusIn.call(this,e); 
	};
	$('.ajax-popup-link').magnificPopup({
		type: 'ajax',
		showCloseBtn: true,
		removalDelay: 500,
		mainClass: 'mfp-zoom-in',
		tLoading: '',		
		callbacks: {
		    ajaxContentAdded: function() {
			    heightMain();
				pluginsMaterialize();
				initHtmlEditor();
				masks();
				$(".zozoTabs").zozoTabs();
		    },
		    close: function() {
		    	heightMainReset();
		    }
		}
	}, 0);
	$('.ajax-popup-link.mfp-large').magnificPopup({
		type: 'ajax',
		showCloseBtn: true,
		removalDelay: 500,
		mainClass: 'mfp-zoom-in mfp-large',
		tLoading: '',		
		callbacks: {
		    ajaxContentAdded: function() {
			    heightMain();
				pluginsMaterialize();
				initHtmlEditor();
				masks();
				$(".zozoTabs").zozoTabs();
		    },
		    close: function() {
		    	heightMainReset();
		    }
		}
	}, 0);	
	//Chamar função para ajustas os breadcrumbs
	breadcrumbs();
	
	//Chamar função para ajustar a altura da page para sempre ser 100%
	heightPage();
	
	//Adiciona o footer correto nas data-tables
	dataTableFooter();
	
	//masks();
	
	var url = location.href.split('?');
	var url = url[0].split('#');
	var url = url[0].split('/');
	var moduleBaseUrl = location.origin + '/' + url[3] + '/' + url[4];
	$('#menu-principal > li').each(function(){
	  if ($(this).find('ul').length > 0) {
		var nomeModulo = $('a.collapsible-header', this).text().replace($('a.collapsible-header i:first-child', this).text(), '').replace($('a.collapsible-header i:last-child', this).text(), '');
	    $('.collapsible-body li', this).each(function(){
		    var nomeSubModulo = $('a', this).text();
	      if (moduleBaseUrl == $('a', this).attr('href')) {
	        $(this).addClass('ativo').closest('.collapsible').find('.collapsible-header').trigger('click');
	        $('#breadcrumbs .nav-wrapper').append('<a class="breadcrumb" href="javascript:void(0)">' + nomeModulo + '</a>');
	        $('#breadcrumbs .nav-wrapper').append('<a class="breadcrumb" href="javascript:void(0)">' + nomeSubModulo + '</a>');
	      }
	    })
	  } else {
		var nomeModulo = $('a', this).text().replace($('a i', this).text(), '');
	    if (moduleBaseUrl == $('a', this).attr('href')) {
	      $(this).addClass('ativo');
	      $('#breadcrumbs .nav-wrapper').append('<a class="breadcrumb" href="javascript:void(0)">' + nomeModulo + '</a>');
	    }
	  }
	});
	
	
});

/*
function masks() {
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0 0000-0000');
    $('.phone_with_ddd').mask('(00) 0 0000-0000');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
}
*/

function breadcrumbs() {
	var itenspage = $(".breadcrumb-content a");
	var breadcrumbinicial = $("#breadcrumbs .breadcrumb");
	
	itenspage.insertAfter(breadcrumbinicial);
}

function heightPage() {
	var windowheight = $(window).height();
	
	var headerHeight = $("header").height();
	var pageHeight = $(".page").height() + 64;
	var footerHeight = $("footer").height() + 40;
	
	var somaHeight = headerHeight + pageHeight + footerHeight;
	
	if (windowheight > somaHeight) {
		var diferenca = windowheight - somaHeight;
		$(".page").css("min-height",diferenca);
	}
	
	//$(".page-login").css("min-height",windowheight);
	$(".page-login .icone-admin").css("top",(windowheight / 2)).addClass("start");
}

function heightMain() {
	var windowWidth = $(window).width();
	if (windowWidth < 601) {
		$("main").css("height","0px").css("overflow","hidden");
	}
}
function heightMainReset() {
	var windowWidth = $(window).width();
	if (windowWidth < 601) {
		$("main").css("height","inherit").css("overflow","auto");
	}
}

function multiSelectSearch(c) {
	//$(c).multiSelect();
	$(c).multiSelect({
		//selectableHeader: "<div class='search-container'><input type='text' class='search-input' autocomplete='off' placeholder='Buscar'></div>",
		//selectionHeader: "<div class='search-container'><input type='text' class='search-input' autocomplete='off' placeholder='Buscar'></div>",
		afterInit: function(ms){
			var that = this,
			    $selectableSearch = that.$selectableUl.prev().children(),
			    $selectionSearch = that.$selectionUl.prev().children(),
			    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
			    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
			
			that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
			.on('keydown', function(e){
				if (e.which === 40){
					that.$selectableUl.focus();
					return false;
				}
			});
			
			that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
			.on('keydown', function(e){
				if (e.which == 40){
					that.$selectionUl.focus();
					return false;
				}
			});
		},
		afterSelect: function(){
			this.qs1.cache();
			this.qs2.cache();
		},
		afterDeselect: function(){
			this.qs1.cache();
			this.qs2.cache();
		}
	});
}

function dataTableFooter(classePai) {
	if(classePai === undefined){
		classePai = "";
	}
	$(classePai + ' .dataTables_filter').insertAfter($(classePai + ' .header-table .acoes a:last-child'));
	$(classePai + ' .dt-buttons').insertBefore($(classePai + ' .header-table .acoes .dataTables_filter'));
	$(document.createElement('div')).addClass('footer-table').appendTo($(classePai + " .dataTables_wrapper"));
	$(classePai + ' .dataTables_length').appendTo($(classePai + " .footer-table"));
	$(classePai + ' .dataTables_info').appendTo($(classePai + " .footer-table"));
	$(classePai + ' .pagination.simple_numbers').appendTo($(classePai + " .footer-table"));
}

function pluginsMaterialize() {
	$('.tooltipped').tooltip({delay: 50});
	$('select').each(function (){
		if ($(this).hasClass("custom")) {
			// Nada
		} else if ($(this).hasClass("select2")) {
			$(this).select2(); 
		} else if ($(this).hasClass("multiSelect")) {
			multiSelectSearch(this);//$(this).multiSelect()
		} else if ($(this).hasClass("select2tags")) {
			$(this).select2({
				tags: true
			})
		} else {
			$(this).material_select();
		}
	});
	$('.datapicker').colorpicker();
	$('ul.tabs').tabs();
	$('.collapsible').collapsible({
    	accordion : true
    });
    $(".collapsible[data-collapsible='expandable']").collapsible({
    	accordion : false
    });
	$('.dropdown-button').dropdown({
		inDuration: 300,
		outDuration: 225,
		constrain_width: false, // Does not change width of dropdown to that of the activator
		hover: false, // Activate on hover
		gutter: 0, // Spacing from edge
		belowOrigin: false, // Displays dropdown below the button
		alignment: 'left' // Displays dropdown with edge aligned to the left of button
	});
	$('.dropdown-menu').dropdown({
		constrain_width: false, // Does not change width of dropdown to that of the activator
		hover: true, // Activate on hover
	});
	$('.dropdown-nav-bar').dropdown({
		constrain_width: true, // Does not change width of dropdown to that of the activator
		hover: true, // Activate on hover
		belowOrigin: true, // Displays dropdown below the button
	});
	$("input[data-role='materialtags']").materialtags();
	$('.datepicker').pickadate({
	    selectMonths: true,
	    selectYears: 15
	});
	$('.simple-data-table').DataTable( {
        responsive: true,
        select: false, //permite selecionar a linha
        colReorder: false,  //permite arrastar as colunas para onde desejar
        paging: false,
        searching: false,
        ordering: false,
        info: false
    });
}

function initHtmlEditor() {
	$('.froala').froalaEditor({
		heightMin: 200,
		imageDefaultWidth: '100%',
		placeholderText: 'Escreva o conteúdo...',
		imageUploadURL: '/admin/public/ajax/upload.froala.php',
        imageManagerDeleteURL: '/admin/public/ajax/delete.froala.php',
		imageErrorCallback: function (data) {
			// Bad link.
			if (data.errorCode == 1) {
				alert('Erro: Contacte o suporte');
			} else {
				alert('Erro: Tente novamente');
			}
		},
        enter: $.FroalaEditor.ENTER_BR,
    })
    .on('froalaEditor.image.removed', function(e, editor, $img){
	    $.ajax({
		    type:	'post',
		    url:	'/admin/public/ajax/delete.froala.php',
		    data:	{
			    src:	$img.attr('src')
		    },
		    dataType: 'json',
		    success: function(res){
			    console.log(res);
		    },
		    error: function(e){
			    console.log(res);
		    }
	    });
    });
}

function masks() {
	$('.mask-cep').mask('00000-000');
	$('.mask-cpf').mask('000.000.000-00');
	$('.mask-cnpj').mask('00.000.000/0000-00');
	$('.mask-numeric').mask('#0', {
		reverse: true,
		translation: {
			'#': {
				pattern: /-|\d/,
				recursive: true
			}
		},
		onChange: function(value, e) {      
			e.target.value = value.replace(/(?!^)-/g, '').replace(/^,/, '').replace(/^-,/, '-');
		}
	});
	
	$('.mask-money').mask('000.000.000,00', {reverse: true});
	
	$('.mask-date').mask('00/00/0000', {placeholder: '00/00/0000'});
	
	$('.mask-time').mask('00:00:00', {placeholder: '00:00:00'});
	$('.mask-datetime').mask('00/00/0000 00:00', {placeholder: '00/00/0000 00:00'});
	
	var SPMaskBehavior = function (val) {
	    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
	    onKeyPress: function(val, e, field, options) {
	        field.mask(SPMaskBehavior.apply({}, arguments), options);
	    }
	};
	$('.mask-telefone').mask(SPMaskBehavior, spOptions);
}

$('body')
.on('focus', '.invalid', function(){
	$(this).removeClass('invalid');
})
.on('blur', '.mask-date', function(){
	[d, m, Y] = this.value.split('/');
	var Data = new Date(`${Y}-${m}-${d}`);
	if ( !isNaN(Data.getTime()) ) {
		return true;
	}
	
	if ($(this).is(':required')) {
		$(this).focus();
	}
	
	$(this).addClass('invalid');
	toast('Data inválida', 'error');
})
.on('blur', '.mask-cpf', function(){
	if (CPFValido(this.value)) {
		return true;
	}
	
	if ($(this).is(':required')) {
		$(this).focus();
	}
	
	$(this).addClass('invalid');
	toast('CPF inválido', 'error');
})
.on('focus', '.mask-cep:not(.cep-initialized)', function(){
	$(this).cep();
	$(this).addClass('cep-initialized');
})
.on('focus', '.mask-money', function(){
	$(this).mask('000.000.000,00', {reverse: true});
});
