$('btn-cancelar').on('click', function() {
    if (confirm("Tem certeza que deseja cancelar?")) {
        console.log('hit');
    }
});