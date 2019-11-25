
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
            
            var $table = $('#tabelaResultado');
            $table.bootstrapTable({data: data});
            
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
    if (valor === "") {
        valor = "valor";
    }
    var url = "./tabelaErros.php?buscarPor="+ buscarPor + "&valor=" + valor + "&ordenarPor=" + ordenarPor;
        
    $.ajax({
        url: url,
        type: "GET",
        //data: dados,
        complete:
        function () {
            //window.location = "./tabelaErros.php?buscarPor="+ buscarPor + "&valor=" + inputValor.value + "&ordenarPor=" + ordenarPor
            window.location = url;
        }
    });
}
