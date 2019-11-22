// Informar servidor padrão
//var url = "http://localhost/central/criar_usuario";
//var base_url = "http://192.168.0.19/app/";

function execAjax(dst, dados = {}, token, method = "POST", asyncRequest = false) {


    if (method == "GET" && dados != "") {
        dst = dst + "?" + dados;
        dados = null;
    }
      
    /*   
    alert(
        dst + ' - ' +
        dados + ' - ' +
        //token + ' - ' +
        method + ' - '
        );
 
		 alert(
			dst + ' - ' +
			dados + ' - ' +
			token + ' - ' +
			method + ' - ' +
			asyncRequest
            );
    

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        //data: JSON.stringify(obj),
        //data : $("#form").serialize(),
        data : dados,
        contentType : 'application/json',
    });    
          */   

        

         request =$.ajax({
    url: dst,
    type: method,
    beforeSend: function(request) {
      request.setRequestHeader(
        "Authorization",
        "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84");
    }, 
    data: dados,
    contentType : 'application/json',
    /*
    success: function(result) {
      //alert("asdasdas: 654654" + result);
        console.log(result);
    }
    */
    success: function(result) {
        //alert("asdasdas: 654654" + result);
          console.dir(result);
    }
    ,
    error: function(result) {
      if (result.responseText) {
        console.log("testesteste: " + result.responseText);
      }
      return false;
    }
  });
 
  if (request['status'] == 200) {
    console.log("asdasdasd " + request['status'] + '  ' + request['responseText']);
    return request['status'] + '  ' + request['responseText'];
  }
  return false;
}