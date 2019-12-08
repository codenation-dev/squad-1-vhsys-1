// Informar servidor padrão
var base_url = "http://18.188.20.24/central/";


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
      return result
      console.log(result.statusText);
      */
      console.dir(data);
      console.dir(textStatus);      
      console.dir(jqXHR);
      
      funcaoSucesso(jqXHR.statusText, data);
    },    
    error: function(xhr, resp, text) {
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