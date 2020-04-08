$(function() {
    $('#forma_pgmt-cartao').trigger('click');
     $('#info-credito').show();
     
     //$('#numero-cartao').trigger('focusout');
     //$('#creditCardHolderName').trigger('focusout');
    
    $('li.tab').on('change', function() {
        var option = $('input[name=forma_pgmt]:checked').val();
        
        if (option == 'cartao') {
           $('#info-credito').show();
           $('input[name="dados\[paymentMethod\]"]').val('creditCard');
           
        } else if (option == 'boleto') {
            $('#info-credito').hide();
            $('input[name="dados\[paymentMethod\]"]').val('boleto');
        }
    });
    
});

var card = new Card({
    // a selector or DOM element for the form where users will
    // be entering their information
    form: 'form', // *required*
    // a selector or DOM element for the container
    // where you want the card to appear
    container: '.card-wrapper', // *required*

    formSelectors: {
        numberInput: 'input#numero-cartao', // optional — default input[name="number"]
        expiryInput: 'input#mes-ano', // optional — default input[name="expiry"]
        cvcInput: 'input#cod-seg', // optional — default input[name="cvc"]
        nameInput: 'input#creditCardHolderName' // optional - defaults input[name="name"]
    },

    width: 200, // optional — default 350px
    formatting: true, // optional - default true

    // Strings for translation - optional
    messages: {
        validDate: 'valid\ndate', // optional - default 'valid\nthru'
        monthYear: 'mm/yyyy', // optional - default 'month/year'
    },

    // Default placeholders for rendered fields - optional
    placeholders: {
        number: '•••• •••• •••• ••••',
        name: 'Full Name',
        expiry: '••/••',
        cvc: '•••'
    },

    masks: {
        cardNumber: '•' // optional - mask card number
    },

    // if true, will log helpful messages for setting up Card
    debug: false // optional - default false
});