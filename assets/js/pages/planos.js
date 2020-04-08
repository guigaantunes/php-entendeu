$(document).on('click', '.btn-assinar', function() {
    let idPlano = $(this).data('id-plano');
    let vip = $(this).data('vip');
    
    $.ajax({
        method: 'POST',
        url: '/ajax/ajax.assinar.php',
        data: { dados:{id_plano: idPlano, vip: vip} },
        //redirect: '/minha-conta',
        success: function(data) {
            try {
                data = JSON.parse(data);
            }catch(ex) {}

            if (data.status) {
                setInterval(function() {
                    window.location.href = `/pagamento/${data.dados.assinatura}`;
                }, 3000);
            }
        }
    })
    .done(ajaxDefaultReturn);
    
});