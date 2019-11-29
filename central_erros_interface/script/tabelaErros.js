
var $table = $('#tabelaResultado');
  var $arquivar = $('#arquivar');
  var $apagar = $('#apagar');

  $(function() {
    $arquivar.click(function () {
        var objLinha = JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));      
        var url = 'http://localhost/central/erro/arquivar/';
        var id_erro = objLinha[0].id;
        url = url + id_erro;
        ExecutarAcaoApagarArquivar(url, "PUT");
    })
  })

  $(function() {
    $apagar.click(function () {
        var objLinha = JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));      
        var url = 'http://localhost/central/erro/';
        var id_erro = objLinha[0].id;
        url = url + id_erro;
        ExecutarAcaoApagarArquivar(url, "DELETE");
    })
  })

  function ExecutarAcaoApagarArquivar(url, metodo){
    LimparMensagens();

    $.ajax({
        url: url,
        type: metodo,
        beforeSend: function(request) {
          request.setRequestHeader(
            "Authorization",
            token_session);
        },         
        success : function(data, textStatus, jqXHR ){
            //console.log("kkkkkkkkkkkkkkkkkkk: "  +result);
            //console.dir(data);
            //console.dir(textStatus);
            //console.dir(jqXHR.statusText);
            ExibirMensagemSucesso(jqXHR.statusText);
        },
        error: function(xhr, resp, text) {
            console.dir(xhr);//"xhr: " + 

            ExibirMensagemFalha(xhr.statusText);

            
            console.dir("respXXX: " + resp);
            console.dir("textXXX: " + text);
        }
    });
}

window.actionEvents = {	
    'click .callB': function (e, value, row, index) {        
        /*
        alert(e);
        alert(value);
        alert(row);
        alert(index);
        */
    }
};	


function LimparTabelaResultado() {
    
    var tabela = document.getElementById("tabelaResultado");
    var qtd = tabela.rows.length;
	
	while (qtd > 1) {		
		if (tabela.rows[qtd-1].getAttribute("id") != "linhaCabecalho") {
			tabela.deleteRow(qtd-1);
		}
		qtd--;
	}
	ControlarVisibilidadeGrid();
}
	
function ControlarVisibilidadeGrid() {
	
	var tabela = document.getElementById("tabelaResultado");
	
	if (tabela) {
		tabela.style.display = (tabela.rows.length > 1) ? 'table' : 'none';
	}	
}

window.onload = function() {
    var url = 'http://localhost/central/erro';

    if (((pbuscarPor !== "buscarPor") &&
         (pbuscarPor !== "")) ||
        ((pordenarPor !== "pordenarPor") &&
         (pordenarPor !== ""))) {
        url = url + '/' + pbuscarPor + '/' + pvalor + '/' + pordenarPor;
    } 
    
    //alert(url);

    $.ajax({
        url: url,
        type : "GET",
        beforeSend: function(request) {
          request.setRequestHeader(
            "Authorization",
            token_session)
        }, 
        success : function(result) {
            data = JSON.parse(result);
            //console.dir(data);
            
            var $table = $('#tabelaResultado');
            $table.bootstrapTable({data: data});
            $table.on('click-row.bs.table', function(e, value, row, index) {

                var urlDetalhe = "./detalheErro.php?json="+JSON.stringify(value);
                window.location = urlDetalhe;    
              })
            
            ControlarVisibilidadeGrid();
        },
        error: function(xhr, resp, text) {
            ExibirMensagemFalha(text);

            console.log(xhr, resp, text);

            ControlarVisibilidadeGrid();
        }
    });
};

$('#consultar').click(function (e){
    e.preventDefault();
    Consultar();
})

function Consultar(){
    LimparMensagens();
    
    var selectBuscarPor = document.getElementById("buscarPor");
    var inputValor = document.getElementById("valor");
    var selectOrdenarPor = document.getElementById("ordenarPor"); 
    var buscarPor = selectBuscarPor.options[selectBuscarPor.selectedIndex].value;
    var ordenarPor = selectOrdenarPor.options[selectOrdenarPor.selectedIndex].value;
    /*
    var urlBase = 'http://localhost/central/erro/';
    var url = urlBase + buscarPor + '/' + inputValor.value + '/' + ordenarPor;
    var dados = '{"buscarPor":"'+buscarPor+'","valor":"'+inputValor.value+'","ordenarPor":"'+ordenarPor+'"}';
    */

    var valor = inputValor.value;
    if (buscarPor === "") {
        buscarPor = "buscarPor";
    }
    if (valor === "") {
        valor = "valor";
    }
    if (ordenarPor === "") {
        ordenarPor = "ordenarPor";
    }
    var url = "./tabelaErros.php?buscarPor="+ buscarPor + "&valor=" + valor + "&ordenarPor=" + ordenarPor;

    window.location = url;    
}
