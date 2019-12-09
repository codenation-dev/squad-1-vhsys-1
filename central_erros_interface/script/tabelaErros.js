function colunaNivel(value, row) {

return '<h4><span class="label label-default" id="nivel">'+ value+'</span></h4>';
}
function colunaLog(value, row) {
    var linha = JSON.stringify(row);
    //alert(linha);
    var objLinha = JSON.parse(linha);
    //console.dir(objLinha);

    return objLinha.detalhe+'<br>'+objLinha.ip+'<br>'+objLinha.data_hora;
}
var $limparPesquisa = $('#limparPesquisa');
$limparPesquisa.click(function () {
    window.location.href = "./tabelaErros.php";
});


$('#niveis').change(function () {
    $('#valor').val($('#niveis').val());
});

var $ordenarPor = $('#ordenarPor');
$ordenarPor.change(function () {

    var selectOrdenarPor = document.getElementById("ordenarPor"); 
    var ordenarPor = selectOrdenarPor.options[selectOrdenarPor.selectedIndex].value;

    if (ordenarPor !== "") {
        $('#ascDesc').show();
        $('#lblAscDesc').show();
    } else {
        $('#ascDesc').hide();
        $('#lblAscDesc').hide();
        $('#ascDesc').val("");
    }
});


var $buscarPor = $('#buscarPor');
$buscarPor.change(function () {

    var selectBuscarPor = document.getElementById("buscarPor");
    var buscarPor = selectBuscarPor.options[selectBuscarPor.selectedIndex].value;
    if (buscarPor === "nivel") {
        $('#niveis').show();
        $('#lblNiveis').show();

        $('#lblValor').hide();
        $('#valor').hide();

        $('#valor').val($('#niveis').val());
    } else {
        
        $('#niveis').hide();
        $('#lblNiveis').hide();

        $('#valor').val("");
        $('#valor').show();
        $('#lblValor').show();
    }
});

var $table = $('#tabelaResultado');
  var $arquivar = $('#arquivar');
  var $apagar = $('#apagar');

  $(function() {
    $arquivar.click(function () {
        //console.log(JSON.stringify($table.bootstrapTable('getSelections')));
        var objLinha = JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));
        var url = "erro_arquivar";
        ExecutarAcaoApagarArquivar(url, "PUT", objLinha);        
    })
  })

  $(function() {
    $apagar.click(function () {
        //console.dir(token_session);
        var objLinha = JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));      
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
        true,
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
    
    $('#niveis').hide();
    $('#lblNiveis').hide();
    $('#ascDesc').hide();
    $('#lblAscDesc').hide();
    ControlarVisibilidadeGrid();

    var url = 'erro';
    var paramAtualiza = '?email='+email_usuario;

    var metodo = "GET";
    var dados = "";
    var strAux = "";

    if ((pambiente !== "") ||
        (pbuscarPor !== "") ||
        (pvalor !== "") ||
        (pordenarPor !== "") ||
        (parquivados !== "")){        
        metodo = "POST";
        dados = '{"ambiente":"'+pambiente+
                '", "buscarPor":"'+pbuscarPor+
                '", "valor":"'+pvalor+
                '", "ordenarPor":"'+pordenarPor+
                '", "ascDesc":"'+pascDesc+ 
                '", "arquivados":'+parquivados+'}';

        if (pambiente !== "") {
            $('#ambiente').val(pambiente);
        }
        if (pbuscarPor !== "") {
            
            $('#buscarPor').val(pbuscarPor);
            
            if ($('#buscarPor').val() === "nivel") {
                $('#niveis').show();
                $('#valor').hide();
                $('#valor').val($('#niveis').val());
            } else {
                $('#niveis').hide();
                $('#valor').val("");
                $('#valor').show();
            }
        }
        if (pvalor !== "") {
            $('#valor').val(pvalor);
        }
        if (pordenarPor !== "") {
            if (pordenarPor !== "nivel") {
                strAux = "Level";
            } else if (pordenarPor !== "nivel") {
                strAux = "Descrição";
            } else if (pordenarPor !== "titulo") {
                strAux = "Origem";
            }

            $('#ordenarPor').val(pordenarPor);
        }
        if (pascDesc !== "") {
            if (pordenarPor !== "") {
                $('#ascDesc').val(pascDesc);    
                $('#ascDesc').show();
            }           
        }
        if (parquivados !== "") {
            document.getElementById("arquivados").checked = (parquivados === "true");
        }
        
        url = 'recuperar_erro';
        //console.dir(JSON.parse(dados));
    }    

    execAjax(
        url,
        dados, 
        metodo,
        false,
        function(statusText, data) {
            /*
            console.dir(data);
            console.log(statusText);
            */
            retorno = JSON.parse(decodeURIComponent(data));
            //console.dir(retorno);
            
            var $table = $('#tabelaResultado');
            
            $('#tabelaResultado').bootstrapTable({        		
            
                height: $(window).height() - ($('#h').outerHeight(true))- $('#cabecalho').outerHeight(true) - 5,
                        
                data: retorno		
            });

            
            $table.on('dbl-click-row.bs.table', function(e, value, row, index) {

                /*
                se quiser passar apenas o id e usar a rota de obter erro pelo id
                var urlDetalhe = "./detalheErro.php?json="+value.id;
                window.location = urlDetalhe;    

                aí na pagina de detalhe tem que tratar

                console.dir(value);
                console.log(JSON.stringify(value));
                */

                var urlDetalhe = "./detalheErro.php?json="+JSON.stringify(value);
                window.location = urlDetalhe;    
              })
            
            ControlarVisibilidadeGrid();
        },
        function(xhr, resp, text) {
            ExibirMensagemFalha(text);

            //console.log(xhr, resp, text);

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
    var selectAscDesc = document.getElementById("ascDesc");

    var ambiente = selectAmbiente.options[selectAmbiente.selectedIndex].value;
    var buscarPor = selectBuscarPor.options[selectBuscarPor.selectedIndex].value;
    var ordenarPor = selectOrdenarPor.options[selectOrdenarPor.selectedIndex].value;
    var valor = inputValor.value;
    var ascDesc = selectAscDesc.options[selectAscDesc.selectedIndex].value;

    var url = "./tabelaErros.php?ambiente="+ ambiente + 
                               "&buscarPor="+ buscarPor + 
                               "&valor=" + valor + 
                               "&ordenarPor=" + ordenarPor + 
                               "&ascDesc=" + ascDesc + 
                               "&arquivados=" + $('#arquivados').prop('checked');

    window.location = url;    
}
