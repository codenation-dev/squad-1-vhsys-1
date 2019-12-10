var parametrosGet = {
    json: ""
}

window.onload = function() {
    LimparMensagens();

    if (token_session === "") {
      
        ExibirMensagemFalha("Não autenticado - Aguarde enquanto redirecionamos");
        setTimeout(                
          function (){
              window.location.href = "./index.php";
          },3000
        );
      } 
      
      
      parametrosGet = carregarParametros(parametrosGet);
      //console.dir(parametrosGet);
      
      /*
      console.log(pjson);    
      var log = JSON.parse(pjson);
      console.dir(log);
      console.dir(decodeURIComponent(pjson));    
      //JSON.parse(decodeURIComponent(parametrosGet.json));
      */
      
      var log = parametrosGet;
      $('#ip_data').html("Erro no "+ log.ip +" em "+ log.data_hora);
      $('#titulo').html(log.titulo);
      $('#detalhe').html(log.detalhe);
  
      $('#nivel').html(log.nivel);
      $('#frequencia').html(log.frequencia);
      $('#token').html(log.token);


}