$('#voltar').click(function (e){
    window.history.back();
});


window.onload = function() {
    console.log(pjson);
    /*
    console.log(pjson);
    
    var log = JSON.parse(pjson);
    */
    
    //console.dir(log);
    var log = JSON.parse(decodeURIComponent(pjson));
    $('#ip_data').html("Erro no "+ log.ip +" em "+ log.data_hora);
    $('#titulo').html(log.titulo);
    $('#detalhe').html(log.detalhe);

    $('#nivel').html(log.nivel);
    $('#frequencia').html(log.frequencia);
    $('#token').html(log.token);

}