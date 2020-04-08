$(document).on('click', '.btn-pag', function() {
  let pag = $(this).data('id-pag');
  if (pag == 1) {
    showToast("Redirecionando para o pagSeguro", "success");
    showToast("Apos o pagamento entre em contato com (67)991295622 ou via chat para a liberação do acesso", "success");
    window.location.href = `https://pag.ae/7VAxifbVv`;
  } else {
    showToast("Redirecionando para o pagSeguro", "success");
    showToast("Apos o pagamento entre em contato com (67)991295622 ou via chat para a liberação do acesso", "success");
    window.location.href = `https://pag.ae/7VAxhKCev`;
  }
});