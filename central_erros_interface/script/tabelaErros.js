var Anterior = 0;
var Atual = 0;

  function operateFormatter(value, row, index) {
    return [
      '<a class="like" href="javascript:void(0)" title="Like">',
      '<i class="fa fa-heart"></i>',
      '</a>  ',
      '<a class="apagar" href="javascript:void(0)" title="apagar">',
      '<i class="fa fa-trash"></i>',
      '</a>'
    ].join('')
  }
/*
  window.operateEvents = {
    'click .like': function (e, value, row, index) {
      alert('You click like action, row: ' + JSON.stringify(row))
    },
    'click .apagar': function (e, value, row, index) {
      $table.bootstrapTable('apagar', {
        field: 'id',
        values: [row.id]
      })
    }
  }
*/
var $apagar = $('#apagar');
var $arquivar = $('#arquivar');

var parametrosGet = {
    ambiente: "",
    buscarPor: "",
    valor: "",
    ordenarPor: "",
    ascDesc: "",
    arquivados: ""
}

function colunaNivel(value, row) {

return '<h4><span class="label label-default" id="nivel">'+ value+'</span></h4>';
}
function colunaLog(value, row) {
    var linha = JSON.stringify(row);
    var objLinha = JSON.parse(linha);

    return objLinha.detalhe+'<br>'+objLinha.ip+'<br>'+objLinha.data_hora;
}

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

var $limparPesquisa = $('#limparPesquisa');
$limparPesquisa.click(function () {
    window.location.href = "./tabelaErros.php";
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
        var objLinha = JSON.parse(JSON.stringify($table.bootstrapTable('getSelections')));
        var url = "erro_arquivar";
        ExecutarAcaoApagarArquivar(url, "PUT", objLinha);        
    })
  })

  $(function() {
    $apagar.click(function () {
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

function ControlarVisibilidadeSelects() {
    $('#niveis').hide();
    $('#lblNiveis').hide();
    $('#ascDesc').hide();
    $('#lblAscDesc').hide();
}

window.onload = function() {
    LimparMensagens();

    if (token_session === "") {      
        ExibirMensagemFalha("Não autenticado - Aguarde enquanto redirecionamos");
        setTimeout(                
            function (){
                window.location.href = "./index.php";
            },3000
        );
    }

    parametrosGet = carregarParametros(parametrosGet);
    //console.dir(parametrosGet);

    ControlarVisibilidadeGrid();
    ControlarVisibilidadeSelects();

    var url = 'erro';
    var paramAtualiza = '?email='+email_usuario;

    var metodo = "GET";
    var dados = "";
    
    if ((parametrosGet.ambiente !== "") ||
        (parametrosGet.buscarPor !== "") ||
        (parametrosGet.valor !== "") ||
        (parametrosGet.ordenarPor !== "") ||
        (parametrosGet.arquivados !== "")){        
        metodo = "POST";
        dados = '{"ambiente":"'+parametrosGet.ambiente+
                '", "buscarPor":"'+parametrosGet.buscarPor+
                '", "valor":"'+parametrosGet.valor+
                '", "ordenarPor":"'+parametrosGet.ordenarPor+
                '", "ascDesc":"'+parametrosGet.ascDesc+ 
                '", "arquivados":'+parametrosGet.arquivados+'}';

        if (parametrosGet.ambiente !== "") {
            $('#ambiente').val(parametrosGet.ambiente);
        }
        if (parametrosGet.buscarPor !== "") {
            
            $('#buscarPor').val(parametrosGet.buscarPor);
            
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
        if (parametrosGet.valor !== "") {
            $('#valor').val(parametrosGet.valor);
        }
        if (parametrosGet.ordenarPor !== "") {
            if (parametrosGet.ordenarPor !== "nivel") {
                strAux = "Level";
            } else if (parametrosGet.ordenarPor !== "nivel") {
                strAux = "Descrição";
            } else if (parametrosGet.ordenarPor !== "titulo") {
                strAux = "Origem";
            }

            $('#ordenarPor').val(parametrosGet.ordenarPor);
        }
        if (parametrosGet.ascDesc !== "") {
            if (parametrosGet.ordenarPor !== "") {
                $('#ascDesc').val(parametrosGet.ascDesc);    
                $('#ascDesc').show();
            }           
        }
        
        document.getElementById("arquivados").checked = (parametrosGet.arquivados === true);
        
        url = 'recuperar_erro';
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
            
            //$table.bootstrapTable('destroy').bootstrapTable({
            $('#tabelaResultado').bootstrapTable({        		
                theadClasses: 'thead-light',
                height: $(window).height() - ($('#h').outerHeight(true))- $('#cabecalho').outerHeight(true)- $('#toolbar').outerHeight(true) - 5,
                
                data: retorno		
            });
/*
            */
            $(window).resize(function () {
                
                var Atual = $(window).height();
                if ((Atual > Anterior) ||
                    (Anterior === 0)) {
                    Anterior = Atual;
                    $('#tabelaResultado').bootstrapTable('resetView', {			
                        height: $(window).height() - ($('#h').outerHeight(true))- $('#cabecalho').outerHeight(true)- $('#toolbar').outerHeight(true) - 5,
                    });
                }
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

                
                var urlDetalhe = "./detalheErro.php?"+JSON.stringify(value);
                window.location = urlDetalhe;    
              })

              
    $table.on('check.bs.table uncheck.bs.table ' +
    'check-all.bs.table uncheck-all.bs.table',
  function () {
    $apagar.prop('disabled', !$table.bootstrapTable('getSelections').length);
    $arquivar.prop('disabled', !$table.bootstrapTable('getSelections').length);
  })
            
            ControlarVisibilidadeGrid();
        },
        function(xhr, resp, text) {
            ExibirMensagemFalha(text);

            //console.log(xhr, resp, text);

            ControlarVisibilidadeGrid();

            if (xhr.status === 403) {
                //alert("Por favor, atualize seu cadastro.")
                //window.location.href = "./atualizarCadastro.php"+paramAtualiza;
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

function ObterValorSelect(identificador) {
    //alert(identificador);
    var aaa = document.getElementById(identificador);
    var selectValue = aaa.options[aaa.selectedIndex].value;
    //alert(selectValue);
    return selectValue;
 
}

function Consultar(){    
    
    var inputValor = document.getElementById("valor");    

    var dados = '{"ambiente":"'+ObterValorSelect('ambiente')+
                '", "buscarPor":"'+ObterValorSelect('buscarPor')+
                '", "valor":"'+inputValor.value+
                '", "ordenarPor":"'+ObterValorSelect('ordenarPor')+
                '", "ascDesc":"'+ObterValorSelect('ascDesc')+
                '", "arquivados":'+$('#arquivados').prop('checked')+'}';
    var url = "./tabelaErros.php?"+dados;
    
    window.location = url;    
}
