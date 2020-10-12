function trocavalores(){

    var item = $("#parcelas option:selected").val();
    var item1 = $("#parcelas option:selected").text();
    $("#pagar").attr("data-parcelas",item);
    $(".duration1").text(item);
    item1 =  item1.split(" ");
    $(".value").text(item1[1]);
}