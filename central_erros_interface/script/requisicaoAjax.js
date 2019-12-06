// Informar servidor padrão
var base_url = "http://localhost/central/";



function execAjax(dst, dados = {}, method = "POST", asyncRequest = false, funcaoSucesso, funcaoErro) {

  request = $.ajax({
    type: method,
    data: dados,
    url: base_url + dst,
    async: asyncRequest,
    success: function(data, textStatus, jqXHR ){
      //return result
      //console.log(result.statusText);
            console.dir(data);
            console.dir(textStatus);
            
            console.dir(jqXHR);
      funcaoSucesso(jqXHR.statusText);
    },
    error: function(result) {
      if (result.responseText) {
        funcaoErro(result.responseText);
      }
      return false;
    }
  });

  if (request['status'] == 200) {
    return request['responseText'];
  }
  return false;
}