<?php
    session_start();
    
    $classPlano     = new Plano;
    $classFatura    = new Fatura;
    $classCliente   = new Cliente;
    $Pag            = new PagSeguroRecorrencia;
    $classAssinatura= new Assinatura;
	$pag_session_id = $Pag->getSession();

    $id  = (isset($this->parametros[1]) ? $this->parametros[1] : false);

	//$vip    = ($this->parametros[1] == 'plano' && isset($this->parametros[3]));
	$assinatura = $classAssinatura->getById($id);


    if ( ($assinatura['status'] != 1) || ($assinatura['id_cliente'] != $_SESSION['cliente']['id']) || ($assinatura && $assinatura['pagseguro_adesao'] && $classAssinatura->assinaturaAtiva()) || !$assinatura ) {
        echo "<script>window.location.href='/minha-conta'</script>";
    }


    $cliente = $classCliente->getById($_SESSION['cliente']['id']);

    $telefone = preg_replace('/[^0-9]/', '', $cliente['telefone']);
    //var_dump($cliente);
    
    $assinatura = $classAssinatura->getAssinatura();
    $plano      = $classPlano->getById($assinatura['id_plano']);
    $valor      = number_format($assinatura['valor']/100,2,'.','');
    
    if ($assinatura && $assinatura['pagseguro_adesao'])
        $assinaturaAtiva = $classAssinatura->assinaturaAtiva();

?>

<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Minha Conta</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a class="select-hover">Pagamento</a> 
			
		</div>
	</div>
</section>

<section class="section-space separate-all max-size spaces-top">
    
	<div class="pagamento">		
    	
    	
    	
    	<a class="title text-gray text-center">Pagamento</a>
    	
<!--
    	<h3>Selecione a forma de pagamento:</h3>
    	
		<ul class="tabs">
			<li class="tab">
				<input type="radio" name="forma_pgmt" id="forma_pgmt-cartao" value="cartao" checked  />
				<label for="forma_pgmt-cartao"><i class="icon"></i><b>Crédito</b></label>
			</li>
			<li class="tab">
				<input type="radio" name="forma_pgmt" id="forma_pgmt-boleto" value="boleto" />
				<label for="forma_pgmt-boleto"><i class="icon"></i><b>Boleto</b></label>
			</li>   
        </ul>
-->
        
		
		<div class="form-box spaces-top">
			<form  class="form" id='form-login'>
    			<input type="hidden" name="id_assinatura"                   value="<?=$assinatura['id']?>">
                <!--     	PAGSEGURO		  -->
    			<!-- 		payment           -->
        		<input type="hidden" name="dados[paymentMode]" 				value="default" />
        		<input type="hidden" name="dados[paymentMethod]" 			value="creditCard" />
        		<input type="hidden" name="dados[receiverEmail]" 			value="<?=PAGSEGURO_EMAIL?>" />
        		<input type="hidden" name="dados[currency]" 				value="BRL" />	
        		
        		<!-- 		comprador -->
        		<input type="hidden" name="dados[sender_name]" 				value="<?=trim($cliente['nome'])?>" />
        		<input type="hidden" name="dados[sender_CPF]" 				value="<?=$cliente['cpf']?>" />
        		<input type="hidden" name="dados[areaCode]" 			    value="<?=substr($telefone, 0, 2)?>" />
        		<input type="hidden" name="dados[number]" 				    value="<?=substr($telefone, 2, strlen($telefone) - 1)?>" />
        		<input type="hidden" name="dados[senderEmail]" 				value="<?=(SANDBOX) ? PAG_SANDBOX_COMPRADOR : $cliente['email']?>" />
        		<input type="hidden" name="dados[senderHash]" 				value="" />
        		
        		<!-- 		shipping -->
        		<input type="hidden" name="dados[sender_street]" 	value="<?=$cliente['endereco']?>" />
        		<input type="hidden" name="dados[sender_number]" 	value="<?=$cliente['numero']?>" />
        		<input type="hidden" name="dados[sender_complement]"value="não informado" />
        		<input type="hidden" name="dados[sender_district]" 	value="não informado" />
        		<input type="hidden" name="dados[sender_postalCode]"value="<?=$cliente['cep']?>" />
        		<input type="hidden" name="dados[sender_city]" 		value="<?=$cliente['cidade']?>" />
        		<input type="hidden" name="dados[sender_state]" 	value="<?=$cliente['uf']?>" />
<!--         		<input type="hidden" name="dados[sender_state]" 	value="Brasil" /> -->
<!--         		<input type="hidden" name="dados[sender_type]" 			value="3" /> -->
<!--         		<input type="hidden" name="dados[shippingCost]" 			value="0.00" /> -->
<!--         		<input type="hidden" name="dados[billingAddressCountry]" 	value="Brasil" />   -->
  
          
                <!-- Dados do comprador (opcionais) -->  
<!--
                <input name="senderName" type="hidden" value="José Comprador">  
                <input name="senderAreaCode" type="hidden" value="11">  
                <input name="senderPhone" type="hidden" value="56273440">  
                <input name="senderEmail" type="hidden" value="comprador@uol.com.br">
-->
                <!-- ----------------------- -->
                
                <div id="info-credito" >
		            			
        			<input type="hidden" name="credito[creditCardToken]" 				           value="" />
<!--         			<input type="hidden" id="installmentValue" name="credito[installmentValue]"	   value="" /> -->
        			
<!--     			<h2 class="h-mobile">Dados Cartão</h2> -->
        			<div class="card-wrapper">
            			<div class="input-field required">
	            			<input id="numero-cartao" type="tel" name="numero-cartao" value="" placeholder="Número *" />
	            		</div>
<!--
            			<div class="input-field required">
	            			<select id="installments" name="installments" value=""  />
	            			    <option disabled selected>Selecione o número de parcelas</option>
	            			</select>
	            		</div>
-->
	            		<div class="input-field required">
                            <input type="text" id="creditCardHolderName" name="credito[card_name]" placeholder="Titular *" value="<?=trim($cliente['nome'])?>">
		            	</div>
						<div class="input-field required">
							<input id="mes-ano" type="text" data-mask="00/0000" name="mes-ano" value="" placeholder="Mês/Ano * (mm/aaaa)"  />
						</div>
						<div class="input-field required">
							<input id="cod-seg" type="tel" name="cod-seg" value="" placeholder="CVC *"  />
						</div>
						
						<div class="input-field required">
							<input id="creditCardHolderCPF" type="text" name="credito[card_cpf]" value="<?=$cliente['cpf']?>" placeholder="CPF Titular *"  />
						</div>
						<div class="input-field required">
							<input id="creditCardHolderBirthDate" class="mask-date-no-placeholder" type="text" name="credito[card_birthdate]" value="" placeholder="Data de Nascimento Titular *"  />
						</div>
						<div class="input-field col s2 m2 required">
							<input id="creditCardHolderAreaCode" data-mask="00" type="text" name="credito[card_areaCode]" value="<?=substr($telefone, 0, 2)?>" placeholder="Código de Área *"  />
						</div>
						<div class="input-field col s10 m10 required">
							<input id="creditCardHolderPhone" class="mask-telefone-no-ddd" type="text" name="credito[card_phone]" value="<?=substr($telefone, 2, strlen($telefone) - 1)?>" placeholder="Telefone *"  />
						</div>
        			</div>
        		</div>
                
<!--
	    		<div class="input-field required" data-error="Informe o nome do titular">
	    			<input id="email" type="text" name="email" placeholder="Nome do Titular" class="required"/>
	    		</div>
-->
	    		<div class="input-field required">
	    			<input id="sender_email" type="email" name="dados[sender_email]" placeholder="E-mail para cobrança" class="required" value="<?=$cliente['email']?>"/>
	    		</div>
<!--
	    		<div class="cards">
		    		<a class="card-text">Tipo do Cartão</a>
		    		<div class="radio-option">
			    		<label class="container">
						  <input type="radio" name="card-type">
						  <span class="checkmark"></span>
						  <img class="visa" src="<?=URL_SITE?>assets/images/visa.png" alt="" />
						</label>
		    		</div>
					
					<div class="radio-option">
						<label class="container">
						  <input type="radio" name="card-type">
						  <span class="checkmark"></span>
						  <img class="mastercard" src="<?=URL_SITE?>assets/images/mastercard.png" alt="" />
						</label>
					</div>
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="telefone" type="text" name="telefone" placeholder="Número do Cartão" class="required"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="telefone" type="text" name="telefone" placeholder="Data de Validade" class="required"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe sua senha">
	    			<input id="telefone" type="text" name="telefone" placeholder="Código de Segurança" class="required"/>
	    		</div>
-->
	    		<div class="input-field required">
	    			<input id="billingAddressPostalCode" type="text" class="mask-cep" name="credito[billingAddressPostalCode]" placeholder="CEP" class="required" value="<?=$cliente['cep']?>"/>
	    		</div>
	    		<div class="input-field required">
	    			<input id="billingAddressStreet" type="text" name="credito[billingAddressStreet]" placeholder="Endereço para Cobrança" class="required" value="<?=$cliente['endereco']?>"/>
	    		</div>
	    		<div class="input-field required">
	    			<input id="billingAddressNumber" type="number" min='1' name="credito[billingAddressNumber]" placeholder="Número" class="required" value="<?=$cliente['numero']?>"/>
	    		</div>
	    		<div class="input-field required">
	    			<input id="billingAddressComplement" type="text" name="credito[billingAddressComplement]" placeholder="Complemento" class="required" />
	    		</div>
	    		<div class="input-field required">
	    			<input id="billingAddressDistrict" type="text"  name="credito[billingAddressDistrict]" placeholder="Bairro" class="required" />
	    		</div>
	    		<div class="input-field required">
	    			<input id="billingAddressCity" type="text" name="credito[billingAddressCity]" placeholder="Cidade" class="required" value="<?=$cliente['cidade']?>"/>
	    		</div>
	    		<div class="input-field required">
	    			<input id="billingAddressState" data-mask="SS" type="text" name="credito[billingAddressState]" placeholder="Estado" class="required" value="<?=$cliente['uf']?>"/>
	    		</div>
	    		
<!--
	    		<div class="input-field required">
	    			<input id="uf" type="text" name="telefone" placeholder="Estado" class="required"/>
	    		</div>
-->
	    		
	    		
	    		<div class="input-field required" >
		    		<a href="javascript:void(0)" class="btn btn-send" id='btn-send'>enviar</a>
	    		</div>
	    		<script>
                    function ok_cancel() {
                        decisao = confirm("Enviando dados ao PagSeguro...");
                        if (decisao) {
                            console.log("foi");
                            document.getElementById("consultar").disabled = true;
                
                            //document.location.href("insert_cliente.asp");
                        }
                        return false;
                    }
                </script>
	    		<div class="enviar">
    				<a  onclick="ok_cancel();" class="btn btn-pagar orange btn-small " >Confirmar Pagamento</a>
    			</div>
			</form>
			
		</div>
	</div>
	
	<div class="section-plans">
    	<div class="col-plans">
    		<div class="plans">
    			<div class="plan">
    				<div class="flag top-flag orange">
    				    <a class="flag-text">PLANO ESCOLHIDO</a>
    				</div>
    				<div class="plan-info">
    					<a class="title text-orange left"><?=$plano['titulo']?></a>
    					<p class="plan-description small-text text-gray"><?=html_entity_decode($plano['descricao'])?></p>
    				</div>
    				<div>
    					<div>
    						<a class="plan-name text-orange left"><?=($assinatura['vip'] ? 'VIP' : 'Básico')?></a>
    						<a class="plan-price text-orange left">R$ <?=($assinatura['vip'] ? number_format($plano['valor_vip']/100,2,',','.') : number_format($plano['valor_basico']/100,2,',','.') )?><span class="month text-orange">/mês</span></a>

                        </div>
    				</div>
<!--
    				<div class="flag bottom-flag gray">
    					<a class="flag-text">de <?=($dataInicioFormatada ? $dataInicioFormatada : '-')?> até <?=($dataFimFormatada ? $dataFimFormatada : '-')?></a>
    				</div>
-->
    			</div>
    		</div>
    	</div>
	</div>
</section>

<script type="text/javascript" src="<?=PAG_DIRECT_PAYMENT?>"></script>
<script src="/assets/js/plugins/card.js"></script>
<script src="/assets/js/pages/pagamento.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let sessionId = "<?=trim($pag_session_id)?>";
        PagSeguroDirectPayment.setSessionId(sessionId);
    });
    
    $('#installments').on('change', function() {
        let valor = $('#installments option:selected').text() ;
        $('#installmentValue').val( valor.substring(valor.indexOf("$")+1, valor.length) );
    });
    
    $('#numero-cartao').on('focusout', updateInstallmentsDropdown);
    
    function updateInstallmentsDropdown() {
        let $installments = $('#installments');

        let cardBrand = false;
        
        let $cardNumberField = $('#numero-cartao');
        let cardNumber = $cardNumberField.val().replace(/\s/g, '');
        
        $installments.find('option').remove();
        
        PagSeguroDirectPayment.getBrand({
            cardBin: cardNumber,
            success: function(card) {
                //console.log(card);
                if (card && card.brand)
                    cardBrand = card.brand.name;
                    
                PagSeguroDirectPayment.getInstallments({
                    amount: '<?=$valor?>',
                    brand: cardBrand,
                    success: function(response) {
                        
                        
                        let installments = response.installments;
                        let installmentsInfo = installments[ Object.keys(installments)[0] ];
                        
                        //console.log(installmentsInfo);
                        
                        
                        
                        $.each(installmentsInfo, function(i, e) {
                            $installments.append('<option value="'+e.quantity+'">'+e.quantity+'x R$'+e.installmentAmount+'</option>');
                        });
                        
                        $installments.trigger('change');
                        
                    }
                });

            },
    
        });

    }

    
    function isBoleto() {
	    return $('[name=forma_pgmt]:checked').val() == 'boleto';
    }
    
    function submit() {
	    $.ajax({
			type: 'POST',
			url: '/ajax/ajax.pagamento.php', 
			dataType: 'JSON',
			data: $('form').serialize(),
			success: function(data) {
				console.log(data);
				if (data.mensagens[0].tipo == "success") {
					showToast("Pagamento efetuado com sucesso", "success");	
					setTimeout(function() {
						window.location = '/minha-conta';
					}, 1000);
					
				} else {
					$('a.btn-pagar').removeClass('disabled');
					if(data.mensagens[0].mensagem==19007){
					showToast("Estado invalido", "error");}
					else{
					showToast(data.mensagens[0].mensagem, "error");
					}
				}
			},
			error: function(data){
				showToast(data.mensagens[0].tipo, 'error');
				$('a.btn-pagar').removeClass('disabled');
			}
		});
    }
    
	
	$('a.btn-pagar').on('click', function() {
		var self = $(this);
		self.addClass('disabled');
		
    		var numero_cartao = $('input#numero-cartao').val();
		numero_cartao = numero_cartao.replace(/\s/g, '');
    	
   	 	var cvv = $('#cod-seg').val();
		var expirationDate = $('#mes-ano').val();
		[expirationMonth, expirationYear] = expirationDate.split('/');
		console.log(expirationMonth, expirationYear, expirationDate);
		
		var hash = PagSeguroDirectPayment.getSenderHash();
        $('input[name="dados\[senderHash\]"]').val(hash);
        
    		if (isBoleto())
    			return submit();
    	
		(new Promise((resolve, reject) => {
			PagSeguroDirectPayment.createCardToken({
			    cardNumber: numero_cartao,
			    cvv: cvv,
			    expirationMonth: expirationMonth,
			    expirationYear: expirationYear,
			    success: function(data) {
    			    
					console.log('Card Token:', data.card.token);
					$('input[name="credito\[creditCardToken\]"]').val(data.card.token);
					resolve(data.card.token);
				},
			    error: function(data) {
				    console.log(data);
				    reject(data.errors[Object.keys(data.errors)[0]]);
			    }
			});
		})).then((cardToken) => {
			(new Promise((resolve, reject) => {
				var hash = PagSeguroDirectPayment.getSenderHash();
		    	console.log('Sender Hash:', hash);
		    	$('input[name="dados\[senderHash\]"]').val(hash);
		    	
		    	if (hash)
			    	resolve(cardToken, hash);
			    
			    reject();
			})).then(submit, () => {
				self.removeClass('disabled');
				showToast('Erro ao se conectar com pagseguro para gerar credenciais de pagamento', 'error');
			})
		}, (errorMessage) => {
			self.removeClass('disabled');
			showToast('Erro ao processar dados do cartão de crédito: ' + errorMessage, 'error');
		})
    	
	});

</script>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/pagamento.css" type="text/css" rel="stylesheet" media="screen"/>';
// 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materiais.js"></script>';
?>