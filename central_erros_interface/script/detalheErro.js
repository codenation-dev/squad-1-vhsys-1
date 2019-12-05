$('#voltar').click(function (e){
    window.history.back();
});


window.onload = function() {


    var log = this.JSON.parse(decodeURIComponent(pjson));
    console.dir(log);

    $('#ip_data').html("Erro no "+ log.ip +" em "+ log.data_hora);
    $('#titulo').html(log.titulo);
    $('#detalhe').html(log.detalhe);

}