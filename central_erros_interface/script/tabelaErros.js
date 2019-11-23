
function LimparTabelaResultado() {
    
    var tabela = document.getElementById("tabelaResultado");
    var qtd = tabela.rows.length;
    
    //alert(qtd);
	
	while (qtd > 1) {		
        //alert(tabela.rows[qtd-1].getAttribute("id"));
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
            console.dir(data);
            //ExibirMensagemSucesso(result);

            var $table = $('#tabelaResultado');
            $table.bootstrapTable({data: data});
            
            //$table.show();
            ControlarVisibilidadeGrid();
        },
        error: function(xhr, resp, text) {
            ExibirMensagemFalha(text);

            console.log(xhr, resp, text);

            //$('#table').hide();
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

    var urlBase = 'http://localhost/central/erro/';

    var buscarPor = selectBuscarPor.options[selectBuscarPor.selectedIndex].value;
    var ordenarPor = selectOrdenarPor.options[selectOrdenarPor.selectedIndex].value;
    var url = urlBase + buscarPor + '/' + 
                        inputValor.value + '/' + 
                        ordenarPor;

    //alert(url);
    LimparTabelaResultado();
/*
    var minhaRequisicao = execAjax(
        url, 
        '', 
        "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84",
        'GET');*/

    $.ajax({
        url: url,
        type : "GET",
        //async: false,
        beforeSend: function(request) {
          request.setRequestHeader(
            "Authorization",
            token_session);
        }, 
        success : function(result) {
            console.dir(result);
            datas = JSON.parse(result);
            console.dir(datas);
            //alert(datas);
            //ExibirMensagemSucesso(result);

            var $table = $('#tabelaResultado');

            $table.bootstrapTable({data: datas});
            //$table.bootstrapTable('refresh');
            
            //$table.show();
            ControlarVisibilidadeGrid();
        },
        error: function(xhr, resp, text) {
            ExibirMensagemFalha(text);

            console.log(xhr, resp, text);

            //$('#table').hide();
            
           // LimparTabelaResultado();
        }
    });
}
