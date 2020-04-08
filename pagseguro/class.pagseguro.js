
// Essa classe padroniza vários comportamentos na conexão com o pagseguro, dando menos trabalho para implementá-lo por javascript
class CompraPagSeguro {
	// https://dev.pagseguro.uol.com.br/documentacao/pagamento-online/pagamentos/pagamento-transparente
	constructor(sessionId, errorCallback, alwaysCallback){
		if (undefined == sessionId)
			throw 'Pagseguro session not defined';
		
		PagSeguroDirectPayment.setSessionId(sessionId)
		console.log('Session: ', sessionId);
		
		this.errorCallback = errorCallback || console.log;
		this.alwaysCallback = alwaysCallback || new Function('');
		this.emptyCallback = function(emptyValName){ toast(emptyValName + ' não pode estar vazio', 'error'); throw emptyValName+' is empty' }
	}
	
	getPaymentMethods(amount, success, error, complete) {
		this.imageUrlOrigin = 'https://stc.pagseguro.uol.com.br';
		PagSeguroDirectPayment.getPaymentMethods({
		    amount: 	amount || this.emptyCallback('Amount'),
		    success: 	success || this.emptyCallback('Success callback'),
		    error: 		error || this.errorCallback,
		    complete: 	complete || this.alwaysCallback
		});
	}
	
	getCardBrand(cardBin, success, error, complete) {
		return PagSeguroDirectPayment.getBrand({
		    cardBin: 	cardBin || this.emptyCallback('Card Number'),
		    success: 	success || this.emptyCallback('Success callback'),
		    error: 		error || this.errorCallback,
		    complete: 	complete || this.alwaysCallback
		});
	}
	
	getCardToken(bin, brand, cvv, month, year, success, error, complete) {
		var param = {
		    cardNumber: 		bin || this.emptyCallback('Card Number'),
		    brand: 				brand || this.emptyCallback('Brand'),
		    cvv: 				cvv || this.emptyCallback('CVV'),
		    expirationMonth: 	month || this.emptyCallback('Expiration Month'),
		    expirationYear: 	year || this.emptyCallback('Expiration Year'),
		    success: 			success || this.emptyCallback('Success callback'),
		    error: 				error || this.errorCallback,
		    complete: 			complete || this.alwaysCallback
		}
		
		PagSeguroDirectPayment.createCardToken(param);
	}
	
	getInstallments(amount, brand, noInterestUntil, success, error, complete) {
		PagSeguroDirectPayment.getInstallments({
		    amount: 					amount || this.emptyCallback('Amount'),
		    brand: 						brand || this.emptyCallback('Brand'),
		    maxInstallmentNoInterest: 	noInterestUntil || 0,
		    success: 					success || this.emptyCallback('Success callback'),
		    error: 						error || this.errorCallback,
		    complete: 					complete || this.alwaysCallback
		});
	}
	
	getSenderHash() {
		return PagSeguroDirectPayment.getSenderHash();
	}
}