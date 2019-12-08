window.onload = function() {
    LimparMensagens();
    
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    inputemail.value = pemail;
    inputSenha.value = psenha;      
    
    $('#forme').submit(function (e){
        e.preventDefault();
        AtualizaCadastro();
    });
};

function AtualizaCadastro(){
    LimparMensagens();
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    var dados = '{"email":"'+inputemail.value+'","senha":"'+inputSenha.value+'","token":"'+ptoken+'"}';
    url = "atualizar_token_usuario";
 
    $.ajax({
        url: url,
        type: "POST",
        data : dados, 
        success : function(data, textStatus, jqXHR ){
            //console.dir(data);
            //console.dir(textStatus);
            //console.dir(jqXHR.statusText);
            ExibirMensagemSucesso(jqXHR.statusText);
        },
        error: function(xhr, resp, text) {
            /*
            console.dir(xhr);//"xhr: " + 
            console.dir("respXXX: " + resp);
            console.dir("textXXX: " + text);
            */
            ExibirMensagemFalha(xhr.statusText);
        }
    });
}    

