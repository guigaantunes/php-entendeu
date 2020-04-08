$(document).ready(function() {
    showHideField($('#vip-manual'), $('#ativacao_manual').prop('checked'))
});

$('#ativacao_manual').on('change', function() {
    showHideField($('#vip-manual'), $(this).prop('checked'))
});

function showHideField($div, show) {
    if (show) {
        $div.show();
    } else {
        $div.hide();
    }
}