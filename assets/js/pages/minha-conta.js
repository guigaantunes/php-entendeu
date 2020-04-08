$('.btn-cancelar').on('click', function() {
    if (confirm("Tem certeza que deseja cancelar?")) {
        $.ajax({
            method: 'GET',
            url: '/ajax/ajax.cancelar.php?get',
            success: function(data) {
                try {
                    data = JSON.parse(data);
                } catch(ex){}

                if (!data) return;
                console.log(data);
                showToast(data.mensagens[0].mensagem, data.mensagens[0].tipo);

                if (data.mensagens[0].tipo == 'success') {
                    setTimeout(function(){
                        history.go(0);
                    }, 3000);
                }
            }
        });
    }
});