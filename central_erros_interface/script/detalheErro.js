var parametrosGet = {
    json: ""
}

window.onload = function() {
    LimparMensagens();

    parametrosGet = carregarParametros(parametrosGet);
    console.dir(parametrosGet);
    
    /*
    console.log(pjson);    
    var log = JSON.parse(pjson);
    console.dir(log);
    console.dir(decodeURIComponent(pjson));    
    */
    
    var log = JSON.parse(decodeURIComponent(parametrosGet.json));
    $('#ip_data').html("Erro no "+ log.ip +" em "+ log.data_hora);
    $('#titulo').html(log.titulo);
    $('#detalhe').html(log.detalhe);

    $('#nivel').html(log.nivel);
    $('#frequencia').html(log.frequencia);
    $('#token').html(log.token);

}