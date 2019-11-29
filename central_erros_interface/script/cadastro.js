window.onload = function() {
    LimparMensagens();

    if (atualziar === true) {
      var inputemail = document.getElementById("email");
      var inputSenha = document.getElementById("senha");
      inputemail.value = pemail;
      inputSenha.value = psenha;

      var titulo = document.getElementById("tit");
      titulo.innerText = "Atualziar Usuário";
    }
    

    $('#forme').submit(function (e){
        e.preventDefault();
        EnviarCadastro();
    });
};

function EnviarCadastro(){
    LimparMensagens();
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    var dados = '{"email":"'+inputemail.value+'", "senha":"'+inputSenha.value+'"}';
    var url = "http://localhost/central/criar_usuario";

    if (atualziar === true) {      
        //dados = '{"email":"'+pemail+'", "senha":"'+psenha+'"}';
        url = "http://localhost/central/atualizar_token_usuario";
    }
 
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


/*

var parametros = {
    email: "",
    senha: ""
}

var form = document.getElementById("forme");

form.addEventListener("submit", function(event){
    event.preventDefault();		    
    EnviarCadastro();
});
*/