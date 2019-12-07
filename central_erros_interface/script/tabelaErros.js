var $limparPesquisa = $('#limparPesquisa');
$limparPesquisa.click(function () {
    window.location.href = "./tabelaErros.php";
});

var $table = $('#tabelaResultado');
  var $arquivar = $('#arquivar');
  var $apagar = $('#apagar');

  $(function() {
    $arquivar.click(function () {
        console.log(JSON.stringify($table.bootstrapTable('getSelections')));
        var objLinha = JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));
        var url = "erro_arquivar";
        ExecutarAcaoApagarArquivar(url, "PUT", objLinha);        
    })
  })

  $(function() {
    $apagar.click(function () {
        var objLinha = JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));      
        //console.dir(token_session);
        var url = "erro/apagar";
        ExecutarAcaoApagarArquivar(url, "DELETE", objLinha);
    })
  })

  function ExecutarAcaoApagarArquivar(url, metodo, dados){
    LimparMensagens();
    
    execAjax(
        url,
        JSON.stringify(dados), 
        metodo,
        false,
        ExibirMensagemSucesso,
        ExibirMensagemFalha,
        true,
        token_session
    );

    location.reload();
}

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
    ControlarVisibilidadeGrid();

    var url = 'erro';
    var paramAtualiza = '?email='+email_usuario;

    var metodo = "GET";
    var dados = "";

    if (((pbuscarPor !== "buscarPor") &&
         (pbuscarPor !== "")) ||
        ((pordenarPor !== "pordenarPor") &&
         (pordenarPor !== ""))) {
        url = url + '/' + pbuscarPor + '/' + pvalor + '/' + pordenarPor;
        metodo = "POST";
        dados = '{"buscarPor":"'+pbuscarPor+'", "valor":"'+pvalor+'", "ordenarPor":"'+pordenarPor+'"}';
        url = 'recuperar_erro';
    }        

    execAjax(
        url,
        dados, 
        metodo,
        false,
        function(statusText, data) {
            console.dir(data);
            retorno = JSON.parse(decodeURIComponent(data));
            console.dir(retorno);
            
            var $table = $('#tabelaResultado');
            $table.bootstrapTable({data: retorno});
            //console.dir($table);
            $table.on('dbl-click-row.bs.table', function(e, value, row, index) {

                var urlDetalhe = "./detalheErro.php?json="+JSON.stringify(value);
                window.location = urlDetalhe;    
              })
            
            ControlarVisibilidadeGrid();
        },
        function(xhr, resp, text) {
            ExibirMensagemFalha(text);

            console.log(xhr, resp, text);

            ControlarVisibilidadeGrid();

            if (xhr.status === 403) {
                alert("Por favor, atualize seu cadastro.")
                window.location.href = "./atualizarCadastro.php"+paramAtualiza;
            }
        },
        true,
        token_session
    );
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
