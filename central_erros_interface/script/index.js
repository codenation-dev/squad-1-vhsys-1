var parametros = {
    email: "",
    senha: ""
}


LimparMensagens();

function Consultar(){
    LimparMensagens();
    var url = 'http://localhost/central/erro/2';
    
/*
    var minhaRequisicao = execAjax(
        url, 
        '', 
        "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84",
        'GET');*/



    $.ajax({
        url: url,
        type : "GET",
        beforeSend: function(request) {
          request.setRequestHeader(
            "Authorization",
            "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84");
        }, 
        success : function(result) {
            console.log("vvvvvvvvvvvvvvvvvv: "  +result);
            ExibirMensagemSucesso(result);
        },
        error: function(xhr, resp, text) {

            ExibirMensagemFalha(text);

            console.log(xhr, resp, text);
        }
    });

    /*
    console.log(url);
    Requisicao.ExecutarGet(
        url,
        '',
        false,
        function (TextoResposta) {
            try {
                console.log(TextoResposta);
            }
            catch (err) {
                console.log("Falha ao ler retorno: " + err.message)
            }
        }

    );
    */
}

var btnCons = document.getElementById("cons"); 

btnCons.addEventListener("click", function(event){
    event.preventDefault();		    
    Consultar();
});


var form = document.getElementById("forme");

form.addEventListener("submit", function(event){
    event.preventDefault();		    
    EnviarCadastro();
});


function EnviarCadastro(){
    LimparMensagens();
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    var dados = '{"email":"'+inputemail.value+'", "senha":"'+inputSenha.value+'"}';
    var url = "http://localhost/central/criar_usuario";

 
    //alert(url);
    
    $.ajax({
        url: url,
        type: "POST",
        beforeSend: function(request) {
          request.setRequestHeader(
            "Authorization",
            "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84");
        }, 
       // dataType: 'json',
       // contentType : 'application/json',
        data : dados, 
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
