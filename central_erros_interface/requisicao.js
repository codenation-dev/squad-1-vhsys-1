/*
Specifies the type of request
open(method, url, async)	

method: the type of request: GET or POST
url: the server (file) location
async: true (asynchronous) or false (synchronous)
send()	Sends the request to the server (used for GET)
send(string)	Sends the request to the server (used for POST)
*/

var Requisicao = {

	ObterXMLHTTP : function () {
	  var resultado = false;

		if (!resultado && typeof XMLHttpRequest != "undefined") {
		  resultado = new XMLHttpRequest();
		}

		return resultado;
	},

	ExecutarRequisicao: function (
	  metodo,
	  url,
	  parametros,
	  assincrono,
	  funcaoOnReadyStateChange
	) {
		/*
		 alert(
			metodo + ' - ' +
			url + ' - ' +
			parametros + ' - ' +
			assincrono + ' - ' +
			funcaoOnReadyStateChange
			);
		*/
	  var theURL = url;
	  var parametrosSend = parametros;

	  if (metodo == "GET" && parametros != "") {
		theURL = theURL + "?" + parametros;
		parametrosSend = null;
	  }
	  var xmlhttp = this.ObterXMLHTTP();

	
	  xmlhttp.open(metodo, theURL, true);
	 //xmlhttp.withCredentials = true;
	  xmlhttp.setRequestHeader(
		"Content-type",
		"application/json"
	  );

	  xmlhttp.setRequestHeader(
		"Authorization",
		"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84"
	  );

	  xmlhttp.onreadystatechange = function () {
		//if (xmlhttp.readyState == 4) {
		  //if (xmlhttp.status == 200) {
			  funcaoOnReadyStateChange(xmlhttp.responseText);
		  //}
		//}
	  };

	  xmlhttp.send(parametrosSend);
	},

	ExecutarGet: function (url, parametros, assincrono, funcaoOnReadyStateChange) {
	  this.ExecutarRequisicao(
		"GET",
		url,
		parametros,
		assincrono,
		funcaoOnReadyStateChange
	  );
	},

	ExecutarPost: function (url, parametros, assincrono, funcaoOnReadyStateChange) {
	  this.ExecutarRequisicao(
		"POST",
		url,
		parametros,
		assincrono,
		funcaoOnReadyStateChange
	  );
	},

	ExecutarPut: function (url, parametros, assincrono, funcaoOnReadyStateChange) {
	  this.ExecutarRequisicao(
		"PUT",
		url,
		parametros,
		assincrono,
		funcaoOnReadyStateChange
	  );
	},

	ExecutarDelete: function (url, parametros, assincrono, funcaoOnReadyStateChange) {
	  this.ExecutarRequisicao(
		"DELETE",
		url,
		parametros,
		assincrono,
		funcaoOnReadyStateChange
	  );
	}
}