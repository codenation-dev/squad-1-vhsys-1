/*
tem que tirar o token fixo
*/
//const token_padrao = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzYyMTA1NDQsImlhdCI6MTU3NTg1MDU0NH0.wZj1zZFl2tb0nfhPC6Oh5XeXW34YQZ0tIIq2sZpBHvk";
// Informar servidor padrão
//var base_url = "http://18.188.20.24/central/";
var base_url = "http://localhost/central/";


function execAjax(
  dst, 
  dados = {}, 
  method = "POST", 
  asyncRequest = false,  
  funcaoSucesso, 
  funcaoErro,
  usarBaseURL = true,
  token = "",
  contentType = "") {
/*
  alert(
    "dst ="+ dst +
    "dados ="+ dados +
    "method ="+ method +
    "asyncRequest ="+ asyncRequest +
    "usarBaseURL ="+ usarBaseURL +
    "token ="+ token 
  );
*/

  urlDst = dst;
  if (usarBaseURL === true) {
    urlDst = base_url + dst;
  }

  request = $.ajax({
    type: method,
    data: dados,
    url: urlDst,
    async: asyncRequest,
    contentType: contentType,
    beforeSend: function(request) {
      if (token !== "") {
        request.setRequestHeader(
          "Authorization",
          token)
      }      
    }, 
    success: function(data, textStatus, jqXHR ){
      /*
      console.dir(data);
      console.dir(textStatus);      
      console.dir(jqXHR);
      */
      
      funcaoSucesso(jqXHR.statusText, data);
    },    
    error: function(xhr, resp, text) {   
      console.dir(xhr);
      funcaoErro(xhr.status, xhr.statusText);      
    }
  });

  /*
  if (request['status'] == 200) {
    return request['responseText'];
  }
  */
  return request['responseText'];
  //return false;
}