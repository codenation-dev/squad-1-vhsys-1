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

    if ((pambiente !== "") ||
        (pbuscarPor !== "") ||
        (pvalor !== "") ||
        (pordenarPor !== "")){        
        metodo = "POST";
        dados = '{"ambiente":"'+pambiente+'", "buscarPor":"'+pbuscarPor+'", "valor":"'+pvalor+'", "ordenarPor":"'+pordenarPor+'"}';
        url = 'recuperar_erro';
        console.dir(JSON.parse(dados));
    }    

    execAjax(
        url,
        dados, 
        metodo,
        true,
        function(statusText, data) {
            /*
            console.dir(data);
            console.log(statusText);
            */
            retorno = JSON.parse(decodeURIComponent(data));
            //console.dir(retorno);
            
            var $table = $('#tabelaResultado');
            $table.bootstrapTable({data: retorno});
            
            $table.on('dbl-click-row.bs.table', function(e, value, row, index) {

                var urlDetalhe = "./detalheErro.php?json="+JSON.stringify(value);

                /*
                console.log(value);
                console.dir(JSON.stringify(value));
                */
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
    
    var selectAmbiente = document.getElementById("ambiente");
    var selectBuscarPor = document.getElementById("buscarPor");
    var inputValor = document.getElementById("valor");    
    var selectOrdenarPor = document.getElementById("ordenarPor"); 

    var ambiente = selectAmbiente.options[selectAmbiente.selectedIndex].value;
    var buscarPor = selectBuscarPor.options[selectBuscarPor.selectedIndex].value;
    var ordenarPor = selectOrdenarPor.options[selectOrdenarPor.selectedIndex].value;
    var valor = inputValor.value;

    /*
    if (ambiente === "") {
        ambiente = "ambiente";
    }
    if (buscarPor === "") {
        buscarPor = "buscarPor";
    }
    if (valor === "") {
        valor = "valor";
    }
    if (ordenarPor === "") {
        ordenarPor = "ordenarPor";
    }
    */
    var url = "./tabelaErros.php?ambiente="+ ambiente + "&buscarPor="+ buscarPor + "&valor=" + valor + "&ordenarPor=" + ordenarPor;

    window.location = url;    
}
